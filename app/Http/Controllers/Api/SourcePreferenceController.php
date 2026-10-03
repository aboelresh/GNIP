<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Source;
use App\Models\UserSourcePreference;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SourcePreferenceController extends Controller
{
    /**
     * Return all sources with the authenticated user's preference for each.
     * Sources with no preference record default to enabled.
     */
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();

        $preferences = $user->sourcePreferences()
            ->pluck('is_enabled', 'source_id');

        $sources = Source::where('is_active', true)
            ->orderBy('name')
            ->get()
            ->map(function (Source $source) use ($preferences) {
                return [
                    'id'                => $source->id,
                    'name'              => $source->name,
                    'slug'              => $source->slug,
                    'country_code'      => $source->country_code,
                    'language'          => $source->language,
                    'bias'              => $source->bias,
                    'type'              => $source->type,
                    'reliability_score' => $source->reliability_score,
                    'website_url'       => $source->website_url,
                    'is_enabled'        => $preferences->get($source->id, true),
                ];
            });

        return response()->json([
            'status' => 'ok',
            'data'   => [
                'sources'       => $sources,
                'total'         => $sources->count(),
                'enabled_count' => $sources->where('is_enabled', true)->count(),
            ],
        ]);
    }

    /**
     * Toggle a single source on or off.
     */
    public function toggle(Request $request, Source $source): JsonResponse
    {
        
        $request->validate([
            'is_enabled' => ['required', 'boolean'],
        ]);

        $user = $request->user();

        $preference = UserSourcePreference::updateOrCreate(
            [
                'user_id'   => $user->id,
                'source_id' => $source->id,
            ],
            [
                'is_enabled' => $request->boolean('is_enabled'),
            ]
        );

        return response()->json([
            'status' => 'ok',
            'data'   => [
                'source_id'  => $source->id,
                'source'     => $source->name,
                'is_enabled' => $preference->is_enabled,
            ],
        ]);
    }

    /**
     * Bulk update all source preferences at once.
     */
    public function bulkUpdate(Request $request): JsonResponse
    {
        $request->validate([
            'sources'            => ['required', 'array'],
            'sources.*.id'       => ['required', 'integer', 'exists:sources,id'],
            'sources.*.enabled'  => ['required', 'boolean'],
        ]);

        $user = $request->user();

        foreach ($request->sources as $item) {
            UserSourcePreference::updateOrCreate(
                [
                    'user_id'   => $user->id,
                    'source_id' => $item['id'],
                ],
                [
                    'is_enabled' => $item['enabled'],
                ]
            );
        }

        return response()->json([
            'status'  => 'ok',
            'message' => 'Source preferences updated.',
            'data'    => [
                'updated' => count($request->sources),
            ],
        ]);
    }

    /**
     * Reset all preferences to enabled (default state).
     */
    public function reset(Request $request): JsonResponse
    {
        $request->user()
            ->sourcePreferences()
            ->delete();

        return response()->json([
            'status'  => 'ok',
            'message' => 'All source preferences reset to default.',
        ]);
    }
}