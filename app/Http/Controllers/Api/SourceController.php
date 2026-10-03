<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Source;
use App\Repositories\ArticleRepository;
use App\Services\Feed\FeedFetcher;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SourceController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Source::query();

        if ($request->has('active')) {
            $query->where('is_active', $request->boolean('active'));
        }

        if ($request->has('language')) {
            $query->where('language', $request->get('language'));
        }

        if ($request->has('type')) {
            $query->where('type', $request->get('type'));
        }

        if ($request->has('bias')) {
            $query->where('bias', $request->get('bias'));
        }

        $sources = $query->withCount('articles')->get()->map(fn($source) => [
            'id'                     => $source->id,
            'name'                   => $source->name,
            'slug'                   => $source->slug,
            'website_url'            => $source->website_url,
            'country_code'           => $source->country_code,
            'language'               => $source->language,
            'bias'                   => $source->bias,
            'type'                   => $source->type,
            'reliability_score'      => $source->reliability_score,
            'reliability_label'      => $source->getReliabilityLabel(),
            'is_active'              => $source->is_active,
            'fetch_interval_minutes' => $source->fetch_interval_minutes,
            'last_fetched_at'        => $source->last_fetched_at,
            'articles_count'         => $source->articles_count,
        ]);

        return response()->json([
            'status' => 'ok',
            'data'   => $sources,
            'meta'   => ['total' => $sources->count()],
        ]);
    }

    public function show(Source $source): JsonResponse
    {
        return response()->json([
            'status' => 'ok',
            'data'   => [
                'id'                     => $source->id,
                'name'                   => $source->name,
                'slug'                   => $source->slug,
                'website_url'            => $source->website_url,
                'feed_url'               => $source->feed_url,
                'country_code'           => $source->country_code,
                'language'               => $source->language,
                'bias'                   => $source->bias,
                'type'                   => $source->type,
                'reliability_score'      => $source->reliability_score,
                'reliability_label'      => $source->getReliabilityLabel(),
                'is_active'              => $source->is_active,
                'fetch_interval_minutes' => $source->fetch_interval_minutes,
                'last_fetched_at'        => $source->last_fetched_at,
                'articles_count'         => $source->articles()->count(),
                'is_due_for_fetch'       => $source->isDueForFetch(),
            ],
        ]);
    }

       public function fetch(Source $source, FeedFetcher $fetcher, ArticleRepository $repository): JsonResponse
    {
        if (! $source->is_active) {
            return response()->json(['status' => 'error', 'message' => 'Source is inactive.'], 422);
        }

        $items   = $fetcher->fetch($source);
        $results = $repository->storeBatch($items, $source);
        $source->markAsFetched();

        // ─── Invalidate related cache ──────────────────────────────
        Cache::forget('dashboard:stats');
        Cache::forget("sources:{$source->id}");

        return response()->json([
            'status'  => 'ok',
            'message' => "Fetched {$results['stored']} new articles.",
            'data'    => $results,
        ]);
    }
}