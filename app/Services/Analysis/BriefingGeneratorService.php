<?php

namespace App\Services\Analysis;

use App\Models\Briefing;
use App\Models\Story;
use App\Services\AI\AIManager;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class BriefingGeneratorService
{
    public function __construct(
        private readonly AIManager $ai
    ) {
    }

    public function generateDaily(): ?Briefing
    {
        $start = now()->subDay()->startOfDay();
        $end = now()->subDay()->endOfDay();

        return $this->generate('daily', $start, $end);
    }

    public function generateWeekly(): ?Briefing
    {
        $start = now()->subWeek()->startOfWeek();
        $end = now()->subWeek()->endOfWeek();

        return $this->generate('weekly', $start, $end);
    }

    public function generateMonthly(): ?Briefing
    {
        $start = now()->subMonth()->startOfMonth();
        $end = now()->subMonth()->endOfMonth();

        return $this->generate('monthly', $start, $end);
    }

    private function generate(string $type, Carbon $start, Carbon $end): ?Briefing
    {
        Log::info("BriefingGeneratorService: generating {$type} briefing.");

        // ─── Check if already exists ───────────────────────────────
        $exists = Briefing::where('type', $type)
            ->where('period_start', $start->toDateString())
            ->where('period_end', $end->toDateString())
            ->where('status', 'published')
            ->first();

        if ($exists) {
            Log::info("Briefing already exists for {$type} {$start->toDateString()}");

            return $exists;
        }

        // ─── Get top stories for the period ───────────────────────
        $stories = Story::with(['category', 'articles.source'])
            ->where('is_published', true)
            ->where('first_reported_at', '>=', $start)
            ->where('first_reported_at', '<=', $end)
            ->orderByDesc('importance_score')
            ->limit($type === 'daily' ? 10 : ($type === 'weekly' ? 20 : 30))
            ->get();

        if ($stories->isEmpty()) {
            // fallback: get recent stories
            $stories = Story::with(['category', 'articles.source'])
                ->where('is_published', true)
                ->orderByDesc('importance_score')
                ->limit(10)
                ->get();
        }

        if ($stories->isEmpty()) {
            Log::warning("No stories found for {$type} briefing.");

            return null;
        }

        // ─── Create briefing record ────────────────────────────────
        $briefing = Briefing::create([
            'type' => $type,
            'status' => 'generating',
            'title' => $this->getDefaultTitle($type, $start),
            'period_start' => $start->toDateString(),
            'period_end' => $end->toDateString(),
            'stories_count' => $stories->count(),
            'sources_count' => $stories->sum('sources_count'),
            'articles_count' => $stories->sum('articles_count'),
        ]);

        try {
            // ─── Generate AI content ───────────────────────────────
            $content = $this->generateContent($stories, $type);

            // ─── Attach stories ────────────────────────────────────
            foreach ($stories as $index => $story) {
                $section = $story->category?->slug ?? 'international';
                $briefing->stories()->attach($story->id, [
                    'order' => $index + 1,
                    'section' => in_array($section, $this->allowedSections())
                        ? $section : 'other',
                    'summary' => json_encode([
                        'en' => $story->getTranslatedSummary('en'),
                        'ar' => $story->getTranslatedSummary('ar'),
                    ]),
                ]);
            }

            // ─── Update briefing ───────────────────────────────────
            $briefing->update([
                'title' => $content['titles'] ?? $this->getDefaultTitle($type, $start),
                'introduction' => $content['introductions'] ?? null,
                'sections' => $content['sections'] ?? null,
                'conclusion' => $content['conclusions'] ?? null,
                'top_stories' => $content['top_stories'] ?? null,
                'key_developments' => $content['key_developments'] ?? null,
                'languages_available' => ['en', 'ar'],
                'status' => 'published',
                'generated_at' => now(),
                'published_at' => now(),
            ]);

            Log::info("Briefing [{$type}] generated successfully. ID: {$briefing->id}");

            return $briefing;

        } catch (\Exception $e) {
            Log::error('BriefingGeneratorService failed: '.$e->getMessage());
            $briefing->markAsFailed();

            return null;
        }
    }

    private function generateContent($stories, string $type): array
    {
        $typeLabel = match ($type) {
            'daily' => 'daily news briefing',
            'weekly' => 'weekly news summary',
            'monthly' => 'monthly news review',
            default => 'news briefing',
        };

        $storiesSummary = $stories->take(5)->map(function ($story, $index) {
            return ($index + 1).'. '.$story->getTranslatedTitle('en')
                .' ['.($story->category?->getTranslatedName('en') ?? 'General').']'
                .' - Sources: '.$story->sources_count
                .' - Evidence: '.$story->evidence_level;
        })->implode("\n");

        $prompt = 'You are a professional news editor creating a '.$typeLabel.'. Based on these top stories, create a structured briefing.

TOP STORIES:
'.$storiesSummary.'

Respond with ONLY a valid JSON object:
{
    "titles": {"en": "English briefing title", "ar": "Arabic title"},
    "introductions": {"en": "2-3 sentence intro in English", "ar": "Arabic intro"},
    "top_stories": {"en": "Brief overview of top 3 stories in English", "ar": "Arabic overview"},
    "key_developments": {"en": "Key developments and trends", "ar": "Arabic key developments"},
    "sections": {"en": "Main sections summary", "ar": "Arabic sections"},
    "conclusions": {"en": "Brief conclusion", "ar": "Arabic conclusion"}
}

Rules:
- Be factual and neutral
- English and Arabic only
- Respond ONLY with JSON, no markdown';

        $response = $this->ai->complete(
            $prompt,
            ['temperature' => 0.3, 'max_tokens' => 1200]
        );

        if (! $response->success) {
            return $this->getFallbackContent($type, $stories);
        }

        $content = trim($response->content);
        $content = preg_replace('/^```(?:json)?\s*/i', '', $content);
        $content = preg_replace('/\s*```$/', '', $content);

        if (preg_match('/\{.*\}/s', $content, $matches)) {
            $content = $matches[0];
        }

        try {
            $data = json_decode($content, true, 512, JSON_THROW_ON_ERROR);

            return is_array($data) ? $data : $this->getFallbackContent($type, $stories);
        } catch (\JsonException $e) {
            return $this->getFallbackContent($type, $stories);
        }
    }

    private function getFallbackContent(string $type, $stories): array
    {
        $topTitles = $stories->take(3)
            ->map(fn ($s) => $s->getTranslatedTitle('en'))
            ->implode(', ');

        return [
            'titles' => $this->getDefaultTitle($type, now()),
            'introductions' => ['en' => "Here are the top stories for this {$type} briefing."],
            'top_stories' => ['en' => $topTitles],
            'key_developments' => ['en' => 'See individual stories for details.'],
            'sections' => ['en' => 'Multiple categories covered.'],
            'conclusions' => ['en' => 'Stay informed with GNIP.'],
        ];
    }

    private function getDefaultTitle(string $type, Carbon $date): array
    {
        $dateStr = $date->format('M d, Y');

        return match ($type) {
            'daily' => [
                'en' => "Daily Briefing — {$dateStr}",
                'ar' => "التقرير اليومي — {$dateStr}",
            ],
            'weekly' => [
                'en' => "Weekly Briefing — Week of {$dateStr}",
                'ar' => "التقرير الأسبوعي — أسبوع {$dateStr}",
            ],
            'monthly' => [
                'en' => "Monthly Briefing — {$date->format('F Y')}",
                'ar' => "التقرير الشهري — {$date->format('F Y')}",
            ],
            default => ['en' => 'News Briefing', 'ar' => 'نشرة إخبارية'],
        };
    }

    private function allowedSections(): array
    {
        return [
            'politics', 'conflicts', 'economy', 'technology',
            'science', 'health', 'sports', 'environment',
            'business', 'international', 'other',
        ];
    }
}
