<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CategoryController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $locale = $request->get('lang', 'en');

        $categories = Cache::remember("categories:all:{$locale}", 3600, function () use ($locale) {
            return Category::active()
                ->ordered()
                ->get()
                ->map(fn($cat) => [
                    'id'          => $cat->id,
                    'slug'        => $cat->slug,
                    'name'        => $cat->getTranslatedName($locale),
                    'description' => $cat->getTranslatedDescription($locale),
                    'icon'        => $cat->icon,
                    'color'       => $cat->color,
                    'order'       => $cat->order,
                ]);
        });

        return response()->json([
            'status' => 'ok',
            'data'   => $categories,
            'meta'   => [
                'locale' => $locale,
                'total'  => $categories->count(),
                'cached' => true,
            ],
        ]);
    }

    public function show(Request $request, Category $category): JsonResponse
    {
        $locale = $request->get('lang', 'en');

        $data = Cache::remember("categories:{$category->id}:{$locale}", 3600, function () use ($category, $locale) {
            return [
                'id'             => $category->id,
                'slug'           => $category->slug,
                'name'           => $category->getTranslatedName($locale),
                'description'    => $category->getTranslatedDescription($locale),
                'icon'           => $category->icon,
                'color'          => $category->color,
                'articles_count' => $category->articles()->count(),
                'stories_count'  => $category->stories()->count(),
            ];
        });

        return response()->json(['status' => 'ok', 'data' => $data]);
    }
}