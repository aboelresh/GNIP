<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Story;
use Inertia\Inertia;
use Inertia\Response;

class StoryController extends Controller
{
    public function show(string $slug): Response
    {
        $story = Story::with([
            'category',
            'articles.source',
            'claims',
            'videos',
        ])->where('slug', $slug)->firstOrFail();

        return Inertia::render('Story', [
            'story' => [
                'id'                        => $story->id,
                'slug'                      => $story->slug,
                'title'                     => $story->getTranslatedTitle('en'),
                'title_ar'                  => $story->getTranslatedTitle('ar'),
                'summary'                   => $story->getTranslatedSummary('en'),
                'what_happened'             => $story->what_happened['en'] ?? null,
                'what_changed'              => $story->what_changed['en'] ?? null,
                'sources_agree'             => $story->sources_agree['en'] ?? null,
                'sources_disagree'          => $story->sources_disagree['en'] ?? null,
                'unconfirmed_claims'        => $story->unconfirmed_claims,
                'evidence_level'            => $story->evidence_level,
                'evidence_score'            => $story->evidence_score,
                'sources_count'             => $story->sources_count,
                'articles_count'            => $story->articles_count,
                'independent_sources_count' => $story->independent_sources_count,
                'importance_score'          => $story->importance_score,
                'is_trending'               => $story->is_trending,
                'countries'                 => $story->countries,
                'languages'                 => $story->languages,
                'tags'                      => $story->tags,
                'image_url'                 => $story->image_url,
                'first_reported_at'         => $story->first_reported_at,
                'last_updated_at'           => $story->last_updated_at,
                'category'                  => $story->category ? [
                    'name'  => $story->category->getTranslatedName('en'),
                    'slug'  => $story->category->slug,
                    'icon'  => $story->category->icon,
                    'color' => $story->category->color,
                ] : null,
                'articles' => $story->articles->map(fn($a) => [
                    'id'           => $a->id,
                    'title'        => $a->title,
                    'url'          => $a->url,
                    'description'  => $a->description,
                    'image_url'    => $a->image_url,
                    'published_at' => $a->published_at,
                    'language'     => $a->language,
                    'perspective'  => $a->pivot->perspective,
                    'source'       => [
                        'name' => $a->source->name,
                        'slug' => $a->source->slug,
                        'bias' => $a->source->bias,
                        'reliability_score' => $a->source->reliability_score,
                    ],
                ]),
                'claims' => $story->claims->map(fn($c) => [
                    'id'                 => $c->id,
                    'text'               => $c->getTranslatedText('en'),
                    'status'             => $c->status,
                    'importance'         => $c->importance,
                    'confirmed_by_count' => $c->confirmed_by_count,
                    'disputed_by_count'  => $c->disputed_by_count,
                    'mentioned_by_count' => $c->mentioned_by_count,
                ]),
            ],
        ]);
    }
}