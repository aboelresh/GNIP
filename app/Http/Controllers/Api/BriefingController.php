<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Briefing;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class BriefingController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $locale = $request->get('lang', 'en');
        $type = $request->get('type', '');
        $page = $request->get('page', 1);

        $briefings = Cache::remember("briefings:index:{$locale}:{$type}:{$page}", 600, function () use ($type) {
            $query = Briefing::published();
            if ($type) {
                $query->where('type', $type);
            }

            return $query->orderByDesc('published_at')->paginate(10);
        });

        return response()->json([
            'status' => 'ok',
            'data' => $briefings->map(fn ($b) => [
                'id' => $b->id,
                'type' => $b->type,
                'title' => $b->getTranslatedTitle($locale),
                'period_start' => $b->period_start?->toDateString(),
                'period_end' => $b->period_end?->toDateString(),
                'stories_count' => $b->stories_count,
                'published_at' => $b->published_at,
            ]),
            'meta' => [
                'total' => $briefings->total(),
                'current_page' => $briefings->currentPage(),
                'last_page' => $briefings->lastPage(),
            ],
        ]);
    }

    public function show(Request $request, Briefing $briefing): JsonResponse
    {
        $locale = $request->get('lang', 'en');
        $cacheKey = "briefings:{$briefing->id}:{$locale}";

        $data = Cache::remember($cacheKey, 600, function () use ($briefing, $locale) {
            $briefing->load('stories.category');

            return [
                'id' => $briefing->id,
                'type' => $briefing->type,
                'title' => $briefing->getTranslatedTitle($locale),
                'introduction' => $briefing->introduction[$locale] ?? $briefing->introduction['en'] ?? null,
                'sections' => $briefing->sections[$locale] ?? $briefing->sections['en'] ?? null,
                'conclusion' => $briefing->conclusion[$locale] ?? $briefing->conclusion['en'] ?? null,
                'top_stories' => $briefing->top_stories[$locale] ?? $briefing->top_stories['en'] ?? null,
                'key_developments' => $briefing->key_developments[$locale] ?? $briefing->key_developments['en'] ?? null,
                'period_start' => $briefing->period_start?->toDateString(),
                'period_end' => $briefing->period_end?->toDateString(),
                'stories_count' => $briefing->stories_count,
                'articles_count' => $briefing->articles_count,
                'sources_count' => $briefing->sources_count,
                'languages_available' => $briefing->languages_available,
                'published_at' => $briefing->published_at,
                'stories' => $briefing->relationLoaded('stories')
                    ? $briefing->stories->map(fn ($s) => [
                        'slug' => $s->slug,
                        'title' => $s->getTranslatedTitle($locale),
                        'section' => $s->pivot->section,
                        'order' => $s->pivot->order,
                        'summary' => is_array($s->pivot->summary)
                            ? ($s->pivot->summary[$locale] ?? $s->pivot->summary['en'] ?? null)
                            : $s->pivot->summary,
                    ])
                    : [],
            ];
        });

        return response()->json(['status' => 'ok', 'data' => $data]);
    }

    public function latest(Request $request, string $type): JsonResponse
    {
        $allowed = ['daily', 'weekly', 'monthly', 'yearly'];

        if (! in_array($type, $allowed)) {
            return response()->json(['status' => 'error', 'message' => 'Invalid briefing type.'], 422);
        }

        $locale = $request->get('lang', 'en');
        $cacheKey = "briefings:latest:{$type}:{$locale}";

        $briefing = Cache::remember($cacheKey, 600, function () use ($type) {
            return Briefing::published()->where('type', $type)->latest('published_at')->first();
        });

        if (! $briefing) {
            return response()->json(['status' => 'error', 'message' => 'No briefing found.'], 404);
        }

        return $this->show($request, $briefing);
    }
}
