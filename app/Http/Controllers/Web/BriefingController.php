<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Briefing;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;

class BriefingController extends Controller
{
        public function index(Request $request): Response
    {
        $type = $request->get('type');

        $briefings = Briefing::published()
            ->when($type, fn($q) => $q->where('type', $type))
            ->orderByDesc('published_at')
            ->get()
            ->map(fn ($b) => [
                'id'           => $b->id,
                'type'         => $b->type,
                'title'        => $b->title,
                'period_start' => $b->period_start?->toDateString(),
                'period_end'   => $b->period_end?->toDateString(),
                'stories_count'=> $b->stories_count,
                'sources_count'=> $b->sources_count,
                'published_at' => $b->published_at,
            ]);

        return Inertia::render('Briefings', [
            'briefings' => $briefings,
            'type'      => $type,
        ]);
    }

        public function show(int $id): Response
    {
        $briefing = Briefing::published()
            ->with('stories.category')
            ->findOrFail($id);

        return Inertia::render('Briefing', [
            'briefing' => [
                'id'               => $briefing->id,
                'type'             => $briefing->type,
                'title'            => $briefing->title,
                'period_start'     => $briefing->period_start?->toDateString(),
                'period_end'       => $briefing->period_end?->toDateString(),
                'stories_count'    => $briefing->stories_count,
                'articles_count'   => $briefing->articles_count,
                'sources_count'    => $briefing->sources_count,
                'published_at'     => $briefing->published_at,
                'stories'          => $briefing->stories->map(fn ($s) => [
                    'slug'  => $s->slug,
                    'title' => $s->getTranslatedTitle('ar') ?: $s->getTranslatedTitle('en'),
                ]),
            ],
        ]);
    }

    public function latest(string $type): Response
    {
        $briefing = Briefing::published()
            ->where('type', $type)
            ->with('stories.category')
            ->latest('published_at')
            ->firstOrFail();

        return Inertia::render('Briefing', [
            'briefing' => [
                'id' => $briefing->id,
                'type' => $briefing->type,
                'title' => $briefing->getTranslatedTitle('ar') ?: $briefing->getTranslatedTitle('en'),
                'introduction' => $briefing->introduction['ar'] ?? $briefing->introduction['en'] ?? null,
                'top_stories' => $briefing->top_stories['ar'] ?? $briefing->top_stories['en'] ?? null,
                'key_developments' => $briefing->key_developments['ar'] ?? $briefing->key_developments['en'] ?? null,
                'conclusion' => $briefing->conclusion['ar'] ?? $briefing->conclusion['en'] ?? null,
                'period_start' => $briefing->period_start?->toDateString(),
                'period_end' => $briefing->period_end?->toDateString(),
                'stories_count' => $briefing->stories_count,
                'articles_count' => $briefing->articles_count,
                'sources_count' => $briefing->sources_count,
                'published_at' => $briefing->published_at,
                'stories' => $briefing->stories->map(fn ($s) => [
                    'slug' => $s->slug,
                    'title' => $s->getTranslatedTitle('en'),
                    'section' => $s->pivot->section,
                    'order' => $s->pivot->order,
                ]),
            ],
        ]);
    }
}
