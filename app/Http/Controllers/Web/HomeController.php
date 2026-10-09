<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Source;
use App\Models\Story;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function index(Request $request): Response
    {
        $query = Story::with(['category', 'articles.source'])
            ->where('is_published', true)
            ->orderBy('last_updated_at', 'desc');

        if ($request->filled('category')) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $request->category)
            );
        }

        if ($request->filled('language')) {
            $query->whereJsonContains('languages', $request->language);
        }

        $stories = $query->paginate(12)
            ->withQueryString()
            ->through(function ($story) {
                $story->setRelation(
                    'sources',
                    $story->articles->pluck('source')->filter()->unique('id')->values()
                );
                $story->unsetRelation('articles');

                return $story;
            });

        $categories = Category::orderBy('name->en')->get()->map(fn ($c) => [
            'id' => $c->id,
            'slug' => $c->slug,
            'name' => $c->name,
        ]);

        return Inertia::render('Home', [
            'stories' => $stories,
            'categories' => $categories,
            'sourcesCount' => Source::where('is_active', true)->count(),
        ]);
    }
}
