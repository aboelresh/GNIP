<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Repositories\ArticleRepository;
use App\Services\AI\AIManager;
use App\Services\AI\ArticleAnalyzer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Article::with(['source', 'category'])
            ->where('is_duplicate', false);

         // Filter by user's source preferences if authenticated
        if ($request->user() && $request->user()->hasSourcePreferences()) {
                 $disabledSourceIds = $request->user()->sourcePreferences()
              ->where('is_enabled', false)
              ->pluck('source_id')
              ->toArray();
              
          if (!empty($disabledSourceIds)) {
             $query->whereNotIn('source_id', $disabledSourceIds);
           }
             
        }
        if ($request->has('status')) {
            $query->where('status', $request->get('status'));
        }

        if ($request->has('language')) {
            $query->where('language', $request->get('language'));
        }

        if ($request->has('country')) {
            $query->where('country_code', strtoupper($request->get('country')));
        }

        if ($request->has('source')) {
            $query->whereHas('source', fn($q) => $q->where('slug', $request->get('source')));
        }

        if ($request->has('category')) {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->get('category')));
        }

        if ($request->has('hours')) {
            $query->where('published_at', '>=', now()->subHours((int) $request->get('hours')));
        }

        if ($request->has('q')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->get('q') . '%')
                    ->orWhere('description', 'like', '%' . $request->get('q') . '%');
            });
        }

        $locale   = $request->get('lang', 'en');
        $perPage  = min((int) $request->get('per_page', 20), 100);
        $articles = $query->orderBy('published_at', 'desc')->paginate($perPage);

        return response()->json([
            'status' => 'ok',
            'data'   => $articles->map(fn($article) => $this->formatArticle($article, $locale)),
            'meta'   => [
                'total'        => $articles->total(),
                'per_page'     => $articles->perPage(),
                'current_page' => $articles->currentPage(),
                'last_page'    => $articles->lastPage(),
            ],
        ]);
    }

    public function show(Request $request, Article $article): JsonResponse
    {
        $article->load(['source', 'category', 'stories', 'entities']);
        $locale = $request->get('lang', 'en');

        return response()->json([
            'status' => 'ok',
            'data'   => $this->formatArticle($article, $locale, detailed: true),
        ]);
    }

    public function analyze(Request $request, Article $article): JsonResponse
    {
        $aiManager = new AIManager();

        if (empty($aiManager->getAvailableProviders())) {
            return response()->json(['status' => 'error', 'message' => 'No AI providers available.'], 503);
        }

        $analyzer = new ArticleAnalyzer($aiManager);
        $result   = $analyzer->analyze($article);
        $article->refresh();

        return response()->json([
            'status'  => $result ? 'ok' : 'error',
            'message' => $result ? 'Article analyzed successfully.' : 'Analysis failed.',
            'data'    => $result ? $this->formatArticle($article->load(['source', 'category']), 'en', detailed: true) : null,
        ], $result ? 200 : 500);
    }

    public function stats(ArticleRepository $repository): JsonResponse
    {
        return response()->json([
            'status' => 'ok',
            'data'   => $repository->getStats(),
        ]);
    }

    private function formatArticle(Article $article, string $locale = 'en', bool $detailed = false): array
    {
        $data = [
            'id'               => $article->id,
            'title'            => $article->title,
            'url'              => $article->url,
            'description'      => $article->description,
            'image_url'        => $article->image_url,
            'author'           => $article->author,
            'language'         => $article->language,
            'country_code'     => $article->country_code,
            'published_at'     => $article->published_at,
            'status'           => $article->status,
            'importance_score' => $article->importance_score,
            'ai_summary'       => $article->getAiSummary($locale),
            'source'           => $article->relationLoaded('source') ? [
                'id'   => $article->source->id,
                'name' => $article->source->name,
                'slug' => $article->source->slug,
                'bias' => $article->source->bias,
            ] : null,
            'category' => $article->relationLoaded('category') ? [
                'id'   => $article->category?->id,
                'name' => $article->category?->getTranslatedName($locale),
                'slug' => $article->category?->slug,
            ] : null,
        ];

        if ($detailed) {
            $data['ai_categories'] = $article->ai_categories;
            $data['is_duplicate']  = $article->is_duplicate;
            $data['duplicate_of']  = $article->duplicate_of;
            $data['stories']       = $article->relationLoaded('stories')
                ? $article->stories->pluck('slug')
                : [];
            $data['entities'] = $article->relationLoaded('entities')
                ? $article->entities->map(fn($e) => ['name' => $e->name, 'type' => $e->type])
                : [];
        }

        return $data;
    }
}