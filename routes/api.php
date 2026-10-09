<?php

use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BriefingController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\SourceController;
use App\Http\Controllers\Api\SourcePreferenceController;
use App\Http\Controllers\Api\StoryController;
use Illuminate\Support\Facades\Route;

// ─── Auth Routes ────────────────────────────────────────────────────────────
Route::prefix('v1')->middleware('throttle:auth')->group(function () {
    Route::post('auth/register', [AuthController::class, 'register']);
    Route::post('auth/login', [AuthController::class, 'login']);
});

// ─── Public Routes ───────────────────────────────────────────────────────────
// ─── Health Check ───────────────────────────────────────────────────────────
Route::get('v1/health', function () {
    $checks = [];
    $status = 'ok';

    // Database check
    try {
        \Illuminate\Support\Facades\DB::connection()->getPdo();
        $checks['database'] = 'ok';
    } catch (\Exception $e) {
        $checks['database'] = 'error';
        $status = 'degraded';
    }

    // Cache check
    try {
        \Illuminate\Support\Facades\Cache::put('health_check', true, 5);
        $checks['cache'] = \Illuminate\Support\Facades\Cache::get('health_check') ? 'ok' : 'error';
    } catch (\Exception $e) {
        $checks['cache'] = 'error';
        $status = 'degraded';
    }

    // Queue check
    try {
        $pendingJobs = \Illuminate\Support\Facades\DB::table('jobs')->count();
        $failedJobs = \Illuminate\Support\Facades\DB::table('failed_jobs')->count();
        $checks['queue'] = [
            'status' => 'ok',
            'pending' => $pendingJobs,
            'failed' => $failedJobs,
        ];
    } catch (\Exception $e) {
        $checks['queue'] = 'error';
    }

    // AI check
    $aiManager = new \App\Services\AI\AIManager();
    $providers = $aiManager->getAvailableProviders();
    $checks['ai'] = [
        'status' => empty($providers) ? 'unavailable' : 'ok',
        'providers' => $providers,
    ];

    // Stats
    $checks['stats'] = [
        'articles' => \App\Models\Article::count(),
        'stories' => \App\Models\Story::where('is_published', true)->count(),
        'sources' => \App\Models\Source::where('is_active', true)->count(),
    ];

    return response()->json([
        'status' => $status,
        'timestamp' => now()->toIso8601String(),
        'version' => '1.0.0',
        'checks' => $checks,
    ], $status === 'ok' ? 200 : 207);
});
Route::prefix('v1')->middleware('throttle:api')->group(function () {
    Route::get('categories', [CategoryController::class, 'index']);
    Route::get('categories/{category}', [CategoryController::class, 'show']);
    Route::get('stories', [StoryController::class, 'index']);
    Route::get('stories/trending/list', [StoryController::class, 'trending']);
    Route::get('stories/{story}', [StoryController::class, 'show']);
    Route::get('articles', [ArticleController::class, 'index'])->middleware('auth.optional');
    Route::get('articles/stats/overview', [ArticleController::class, 'stats']);
    Route::get('articles/{article}', [ArticleController::class, 'show']);
    Route::get('briefings', [BriefingController::class, 'index']);
    Route::get('briefings/latest/{type}', [BriefingController::class, 'latest']);
    Route::get('briefings/{briefing}', [BriefingController::class, 'show']);
    Route::get('dashboard', [DashboardController::class, 'index']);
    Route::get('sources', [SourceController::class, 'index']);
    Route::get('sources/{source}', [SourceController::class, 'show']);
});

// ─── Authenticated Routes ────────────────────────────────────────────────────
Route::prefix('v1')->middleware(['auth:sanctum', 'throttle:api'])->group(function () {
    Route::post('auth/logout', [AuthController::class, 'logout']);
    Route::get('auth/me', [AuthController::class, 'me']);
    Route::put('auth/password', [AuthController::class, 'updatePassword']);

    // ─── Source Preferences ──────────────────────────────────────────────────
    Route::prefix('preferences')->group(function () {
        Route::get('sources', [SourcePreferenceController::class, 'index']);
        Route::put('sources/{source}', [SourcePreferenceController::class, 'toggle']);
        Route::put('sources', [SourcePreferenceController::class, 'bulkUpdate']);
        Route::delete('sources', [SourcePreferenceController::class, 'reset']);
    });
});
// ─── Admin Routes ────────────────────────────────────────────────────────────
Route::prefix('v1')->middleware(['auth:sanctum', 'admin', 'throttle:heavy'])->group(function () {
    Route::post('sources/{source}/fetch', [SourceController::class, 'fetch']);
    Route::post('articles/{article}/analyze', [ArticleController::class, 'analyze']);
});
