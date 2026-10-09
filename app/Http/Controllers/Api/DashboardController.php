<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Briefing;
use App\Models\Category;
use App\Models\Source;
use App\Models\Story;
use App\Services\AI\AIManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    public function index(): JsonResponse
    {
        $data = Cache::remember('dashboard:stats', 300, function () {
            $aiManager = new AIManager();

            return [
                'articles' => [
                    'total' => Article::count(),
                    'today' => Article::where('published_at', '>=', now()->startOfDay())->count(),
                    'raw' => Article::where('status', 'raw')->count(),
                    'processed' => Article::where('status', 'processed')->count(),
                    'duplicates' => Article::where('is_duplicate', true)->count(),
                ],
                'sources' => [
                    'total' => Source::count(),
                    'active' => Source::where('is_active', true)->count(),
                ],
                'stories' => [
                    'total' => Story::count(),
                    'published' => Story::where('is_published', true)->count(),
                    'trending' => Story::where('is_trending', true)->count(),
                ],
                'categories' => Category::where('is_active', true)->count(),
                'briefings' => Briefing::where('status', 'published')->count(),
                'ai' => [
                    'available_providers' => $aiManager->getAvailableProviders(),
                ],
                'languages' => Article::groupBy('language')
                    ->selectRaw('language, count(*) as total')
                    ->pluck('total', 'language'),
            ];
        });

        return response()->json([
            'status' => 'ok',
            'data' => $data,
            'meta' => ['cached' => true, 'ttl_seconds' => 300],
        ]);
    }
}
