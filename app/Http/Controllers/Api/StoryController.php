<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Story;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class StoryController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $locale = $request->get('lang', 'en');
        $perPage = min((int) $request->get('per_page', 20), 100);
        $category = $request->get('category', '');
        $country = $request->get('country', '');
        $evidence = $request->get('evidence_level', '');
        $page = $request->get('page', 1);

        $cacheKey = "stories:index:{$locale}:{$perPage}:{$category}:{$country}:{$evidence}:{$page}";

        $result = Cache::remember($cacheKey, 120, function () use ($locale, $perPage, $category, $country, $evidence) {
            $query = Story::with(['category'])->where('is_published', true);

            if ($category) {
                $query->whereHas('category', fn ($q) => $q->where('slug', $category));
            }
            if ($country) {
                $query->whereJsonContains('countries', strtoupper($country));
            }
            if ($evidence) {
                $query->where('evidence_level', $evidence);
            }

            $stories = $query->orderByDesc('importance_score')->paginate($perPage);

            return [
                'data' => $stories->map(fn ($s) => $this->formatStory($s, $locale)),
                'meta' => [
                    'total' => $stories->total(),
                    'per_page' => $stories->perPage(),
                    'current_page' => $stories->currentPage(),
                    'last_page' => $stories->lastPage(),
                ],
            ];
        });

        return response()->json(['status' => 'ok'] + $result);
    }

    public function show(Request $request, Story $story): JsonResponse
    {
        $locale = $request->get('lang', 'en');
        $cacheKey = "stories:{$story->id}:{$locale}";

        $data = Cache::remember($cacheKey, 300, function () use ($story, $locale) {
            $story->load(['category', 'articles.source', 'claims', 'videos']);

            return $this->formatStory($story, $locale, detailed: true);
        });

        return response()->json(['status' => 'ok', 'data' => $data]);
    }

    public function trending(Request $request): JsonResponse
    {
        $locale = $request->get('lang', 'en');
        $limit = min((int) $request->get('limit', 10), 50);

        $stories = Cache::remember("stories:trending:{$locale}:{$limit}", 180, function () use ($locale, $limit) {
            return Story::published()
                ->trending()
                ->with('category')
                ->orderByDesc('importance_score')
                ->limit($limit)
                ->get()
                ->map(fn ($s) => $this->formatStory($s, $locale));
        });

        return response()->json(['status' => 'ok', 'data' => $stories]);
    }

    private function formatStory(Story $story, string $locale = 'en', bool $detailed = false): array
    {
        $data = [
            'id' => $story->id,
            'slug' => $story->slug,
            'title' => $story->getTranslatedTitle($locale),
            'summary' => $story->getTranslatedSummary($locale),
            'evidence_level' => $story->evidence_level,
            'evidence_score' => $story->evidence_score,
            'importance_score' => $story->importance_score,
            'sources_count' => $story->sources_count,
            'articles_count' => $story->articles_count,
            'independent_sources_count' => $story->independent_sources_count,
            'is_trending' => $story->is_trending,
            'countries' => $story->countries,
            'languages' => $story->languages,
            'image_url' => $story->image_url,
            'first_reported_at' => $story->first_reported_at,
            'last_updated_at' => $story->last_updated_at,
            'category' => $story->relationLoaded('category') ? [
                'name' => $story->category?->getTranslatedName($locale),
                'slug' => $story->category?->slug,
                'icon' => $story->category?->icon,
                'color' => $story->category?->color,
            ] : null,
        ];

        if ($detailed) {
            $data['what_happened'] = $story->what_happened[$locale] ?? $story->what_happened['en'] ?? null;
            $data['what_changed'] = $story->what_changed[$locale] ?? $story->what_changed['en'] ?? null;
            $data['sources_agree'] = $story->sources_agree[$locale] ?? $story->sources_agree['en'] ?? null;
            $data['sources_disagree'] = $story->sources_disagree[$locale] ?? $story->sources_disagree['en'] ?? null;
            $data['unconfirmed_claims'] = $story->unconfirmed_claims;
            $data['tags'] = $story->tags;
            $data['articles'] = $story->relationLoaded('articles')
                ? $story->articles->map(fn ($a) => [
                    'id' => $a->id,
                    'title' => $a->title,
                    'url' => $a->url,
                    'source' => $a->source->name,
                    'published_at' => $a->published_at,
                    'perspective' => $a->pivot->perspective,
                ])
                : [];
            $data['claims'] = $story->relationLoaded('claims')
                ? $story->claims->map(fn ($c) => [
                    'text' => $c->getTranslatedText($locale),
                    'status' => $c->status,
                    'importance' => $c->importance,
                    'confirmed_by_count' => $c->confirmed_by_count,
                    'disputed_by_count' => $c->disputed_by_count,
                ])
                : [];
        }

        return $data;
    }
}
