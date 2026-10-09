<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\Story;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class SearchController extends Controller
{
    public function index(Request $request): Response
    {
        $query = $request->get('q', '');
        $category = $request->get('category', '');
        $language = $request->get('language', '');
        $results = [];

        $articleQuery = Article::with('source', 'category')
            ->where('is_duplicate', false);

        $storyQuery = Story::with('category')->published();

        // ─── Category filter ───────────────────────────────────────
        if ($category) {
            $cat = Category::where('slug', $category)->first();
            if ($cat) {
                $articleQuery->where('category_id', $cat->id);
                $storyQuery->where('category_id', $cat->id);
            }
        }

        // ─── Language filter ───────────────────────────────────────
        if ($language) {
            $articleQuery->where('language', $language);
        }

        // ─── Text search ───────────────────────────────────────────
        if (strlen($query) >= 2) {
            $articleQuery->where(function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                    ->orWhere('description', 'like', "%{$query}%");
            });

            $storyQuery->whereRaw("JSON_EXTRACT(title, '$.en') LIKE ?", ["%{$query}%"])
                ->orWhereRaw("JSON_EXTRACT(title, '$.ar') LIKE ?", ["%{$query}%"]);
        }

        $articles = $articleQuery
            ->orderByDesc('published_at')
            ->limit(30)
            ->get()
            ->map(fn ($a) => [
                'id' => $a->id,
                'title' => $a->title,
                'url' => $a->url,
                'description' => $a->description,
                'image_url' => $a->image_url,
                'language' => $a->language,
                'published_at' => $a->published_at,
                'source' => $a->source?->name,
                'category' => $a->category?->getTranslatedName('ar'),
            ]);

        $stories = $storyQuery
            ->orderByDesc('importance_score')
            ->limit(10)
            ->get()
            ->map(fn ($s) => [
                'slug' => $s->slug,
                'title' => $s->getTranslatedTitle('ar') ?: $s->getTranslatedTitle('en'),
                'evidence_level' => $s->evidence_level,
                'sources_count' => $s->sources_count,
                'category' => $s->category?->getTranslatedName('ar'),
            ]);

        $results = [
            'articles' => $articles,
            'stories' => $stories,
            'total' => $articles->count() + $stories->count(),
            'category' => $category,
        ];

        $categories = Category::active()->ordered()->get()->map(fn ($c) => [
            'slug' => $c->slug,
            'name' => $c->getTranslatedName('ar'),
            'name_en' => $c->getTranslatedName('en'),
            'icon' => $c->icon,
            'color' => $c->color,
        ]);

        return Inertia::render('Search', [
            'query' => $query,
            'category' => $category,
            'language' => $language,
            'results' => $results,
            'categories' => $categories,
        ]);
    }
}
