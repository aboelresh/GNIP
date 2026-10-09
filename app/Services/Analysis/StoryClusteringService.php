<?php

namespace App\Services\Analysis;

use App\Models\Article;
use App\Models\Category;
use App\Models\Story;
use App\Services\AI\AIManager;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class StoryClusteringService
{
    private float $similarityThreshold;

    private int $timeWindowHours;

    private int $minSourcesForStory;

    public function __construct(
        private readonly AIManager $ai
    ) {
        $this->similarityThreshold = config('gnip.clustering.similarity_threshold', 0.7);
        $this->timeWindowHours = config('gnip.clustering.time_window_hours', 48);
        $this->minSourcesForStory = config('gnip.clustering.min_sources_for_story', 2);
    }

    public function run(): array
    {
        Log::info('StoryClusteringService started.');

        $articles = Article::with('source')
            ->where('status', 'processed')
            ->where('is_duplicate', false)
            ->whereDoesntHave('stories')
            ->where('published_at', '>=', now()->subHours($this->timeWindowHours))
            ->orderBy('published_at', 'desc')
            ->limit(200)
            ->get();

        if ($articles->isEmpty()) {
            Log::info('No articles to cluster.');

            return ['clusters' => 0, 'stories_created' => 0, 'articles_clustered' => 0];
        }

        Log::info("Clustering {$articles->count()} articles.");

        $clusters = $this->buildClusters($articles);
        $storiesCreated = 0;
        $articlesClustered = 0;

        foreach ($clusters as $cluster) {
            if ($cluster->count() < 1) {
                continue;
            }

            $story = $this->createOrUpdateStory($cluster);
            if ($story) {
                $storiesCreated++;
                $articlesClustered += $cluster->count();
            }
        }

        Log::info("Clustering done. Stories: {$storiesCreated}, Articles: {$articlesClustered}");

        return [
            'clusters' => count($clusters),
            'stories_created' => $storiesCreated,
            'articles_clustered' => $articlesClustered,
        ];
    }

    private function buildClusters(Collection $articles): array
    {
        $clusters = [];
        $assigned = [];

        foreach ($articles as $article) {
            if (in_array($article->id, $assigned)) {
                continue;
            }

            $cluster = collect([$article]);
            $assigned[] = $article->id;

            foreach ($articles as $other) {
                if (in_array($other->id, $assigned)) {
                    continue;
                }
                if ($this->areSimilar($article, $other)) {
                    $cluster->push($other);
                    $assigned[] = $other->id;
                }
            }

            $clusters[] = $cluster;
        }

        return $clusters;
    }

    private function areSimilar(Article $a, Article $b): bool
    {
        // ─── Time window check ─────────────────────────────────────
        if ($a->published_at && $b->published_at) {
            $hoursDiff = abs($a->published_at->diffInHours($b->published_at));
            if ($hoursDiff > $this->timeWindowHours) {
                return false;
            }
        }

        // ─── Title similarity ──────────────────────────────────────
        $similarity = $this->calculateSimilarity(
            $this->normalizeText($a->title),
            $this->normalizeText($b->title)
        );

        if ($similarity >= $this->similarityThreshold) {
            return true;
        }

        // ─── Category match + partial similarity ───────────────────
        if ($a->category_id && $a->category_id === $b->category_id && $similarity >= 0.4) {
            return true;
        }

        return false;
    }

    private function normalizeText(string $text): string
    {
        $text = strtolower($text);
        $text = preg_replace('/[^\w\s]/u', ' ', $text);
        $text = preg_replace('/\s+/', ' ', trim($text));

        // Remove common stop words
        $stopWords = ['the', 'a', 'an', 'in', 'on', 'at', 'to', 'for', 'of', 'and', 'or', 'is', 'are', 'was', 'were'];
        $words = explode(' ', $text);
        $words = array_filter($words, fn ($w) => ! in_array($w, $stopWords) && strlen($w) > 2);

        return implode(' ', $words);
    }

    private function calculateSimilarity(string $a, string $b): float
    {
        if (empty($a) || empty($b)) {
            return 0.0;
        }

        $wordsA = array_unique(explode(' ', $a));
        $wordsB = array_unique(explode(' ', $b));

        $intersection = array_intersect($wordsA, $wordsB);
        $union = array_unique(array_merge($wordsA, $wordsB));

        if (empty($union)) {
            return 0.0;
        }

        return count($intersection) / count($union);
    }

    private function createOrUpdateStory(Collection $cluster): ?Story
    {
        try {
            $primaryArticle = $cluster->sortByDesc('importance_score')->first();
            $sourceIds = $cluster->pluck('source_id')->unique();
            $languages = $cluster->pluck('language')->unique()->values()->toArray();
            $countries = $cluster->pluck('country_code')->filter()->unique()->values()->toArray();

            // ─── Generate story title & summary via AI ─────────────
            $aiData = $this->generateStoryContent($cluster);

            $slug = $this->generateUniqueSlug($aiData['title_en'] ?? $primaryArticle->title);

            $story = Story::create([
                'category_id' => $primaryArticle->category_id,
                'slug' => $slug,
                'title' => $aiData['titles'] ?? ['en' => $primaryArticle->title],
                'summary' => $aiData['summaries'] ?? ['en' => $primaryArticle->description ?? ''],
                'what_happened' => $aiData['what_happened'] ?? null,
                'sources_agree' => $aiData['sources_agree'] ?? null,
                'sources_disagree' => $aiData['sources_disagree'] ?? null,
                'evidence_level' => $this->calculateEvidenceLevel($sourceIds->count()),
                'evidence_score' => $this->calculateEvidenceScore($sourceIds->count(), $cluster->count()),
                'sources_count' => $sourceIds->count(),
                'articles_count' => $cluster->count(),
                'independent_sources_count' => $sourceIds->count(),
                'importance_score' => (int) $cluster->avg('importance_score'),
                'is_trending' => $cluster->count() >= 3,
                'is_published' => true,
                'countries' => $countries,
                'languages' => $languages,
                'image_url' => $primaryArticle->image_url,
                'first_reported_at' => $cluster->min('published_at'),
                'last_updated_at' => now(),
                'published_at' => now(),
            ]);

            // ─── Attach articles ───────────────────────────────────
            foreach ($cluster as $article) {
                $story->articles()->attach($article->id, [
                    'is_primary' => $article->id === $primaryArticle->id,
                    'relevance_score' => $article->importance_score,
                    'perspective' => 'neutral',
                ]);
            }

            return $story;

        } catch (\Exception $e) {
            Log::error('StoryClusteringService::createOrUpdateStory failed: '.$e->getMessage());

            return null;
        }
    }

    private function generateStoryContent(Collection $cluster): array
    {
        $titles = $cluster->take(3)->pluck('title')->implode(' | ');

        $prompt = 'You are a news editor. Based on these related news article titles, create a unified story.

Titles: '.$titles.'

Respond with ONLY a JSON object:
{"title_en":"Unified English title","titles":{"en":"English","ar":"Arabic","fr":"French","it":"Italian","es":"Spanish"},"summaries":{"en":"2 sentence summary","ar":"Arabic summary","fr":"French summary","it":"Italian summary","es":"Spanish summary"},"what_happened":{"en":"What happened in 3 sentences"},"sources_agree":{"en":"Key facts all sources agree on"},"sources_disagree":{"en":"Points where sources differ or null"}}';

        $response = $this->ai->complete($prompt, ['temperature' => 0.2, 'max_tokens' => 800]);

        if (! $response->success) {
            return [];
        }

        $content = trim($response->content);
        $content = preg_replace('/^```(?:json)?\s*/i', '', $content);
        $content = preg_replace('/\s*```$/', '', $content);

        if (preg_match('/\{.*\}/s', $content, $matches)) {
            $content = $matches[0];
        }

        try {
            return json_decode($content, true, 512, JSON_THROW_ON_ERROR) ?? [];
        } catch (\JsonException $e) {
            return [];
        }
    }

    private function calculateEvidenceLevel(int $sourcesCount): string
    {
        return match (true) {
            $sourcesCount >= 4 => 'high',
            $sourcesCount >= 2 => 'moderate',
            $sourcesCount >= 1 => 'low',
            default => 'unverified',
        };
    }

    private function calculateEvidenceScore(int $sourcesCount, int $articlesCount): int
    {
        $score = ($sourcesCount * 15) + ($articlesCount * 5);

        return min($score, 100);
    }

    private function generateUniqueSlug(string $title): string
    {
        $base = Str::slug($title);
        $slug = $base;
        $i = 1;

        while (Story::where('slug', $slug)->exists()) {
            $slug = $base.'-'.$i++;
        }

        return $slug ?: 'story-'.uniqid();
    }
}
