<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Briefing extends Model
{
    protected $fillable = [
        'type',
        'status',
        'title',
        'introduction',
        'sections',
        'conclusion',
        'top_stories',
        'key_developments',
        'languages_available',
        'period_start',
        'period_end',
        'stories_count',
        'articles_count',
        'sources_count',
        'generated_at',
        'published_at',
        'metadata',
    ];

    protected $casts = [
        'title' => 'array',
        'introduction' => 'array',
        'sections' => 'array',
        'conclusion' => 'array',
        'top_stories' => 'array',
        'key_developments' => 'array',
        'languages_available' => 'array',
        'metadata' => 'array',
        'period_start' => 'date',
        'period_end' => 'date',
        'stories_count' => 'integer',
        'articles_count' => 'integer',
        'sources_count' => 'integer',
        'generated_at' => 'datetime',
        'published_at' => 'datetime',
    ];

    // ─── Relationships ────────────────────────────────────────────

    public function stories(): BelongsToMany
    {
        return $this->belongsToMany(Story::class, 'briefing_story')
            ->withPivot(['order', 'section', 'summary'])
            ->withTimestamps()
            ->orderByPivot('order');
    }

    public function aiLogs(): MorphMany
    {
        return $this->morphMany(AiLog::class, 'subject');
    }

    // ─── Scopes ───────────────────────────────────────────────────

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeByType($query, string $type)
    {
        return $query->where('type', $type);
    }

    public function scopeDaily($query)
    {
        return $query->where('type', 'daily');
    }

    public function scopeWeekly($query)
    {
        return $query->where('type', 'weekly');
    }

    public function scopeMonthly($query)
    {
        return $query->where('type', 'monthly');
    }

    public function scopeYearly($query)
    {
        return $query->where('type', 'yearly');
    }

    // ─── Helpers ──────────────────────────────────────────────────

    public function getTranslatedTitle(string $locale = 'en'): string
    {
        return $this->title[$locale] ?? $this->title['en'] ?? '';
    }

    public function getTranslatedIntroduction(string $locale = 'en'): ?string
    {
        return $this->introduction[$locale] ?? $this->introduction['en'] ?? null;
    }

    public function markAsGenerating(): void
    {
        $this->update(['status' => 'generating']);
    }

    public function markAsPublished(): void
    {
        $this->update([
            'status' => 'published',
            'published_at' => now(),
        ]);
    }

    public function markAsFailed(): void
    {
        $this->update(['status' => 'failed']);
    }

    public function isForDate(\Carbon\Carbon $date): bool
    {
        return $this->period_start->lte($date) && $this->period_end->gte($date);
    }
}
