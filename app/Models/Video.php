<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Video extends Model
{
    protected $fillable = [
        'source_id',
        'category_id',
        'external_id',
        'platform',
        'url',
        'embed_url',
        'title',
        'description',
        'thumbnail_url',
        'channel_name',
        'channel_id',
        'duration_seconds',
        'language',
        'country_code',
        'transcript',
        'ai_summary',
        'importance_score',
        'is_processed',
        'published_at',
        'metadata',
    ];

    protected $casts = [
        'ai_summary'       => 'array',
        'metadata'         => 'array',
        'is_processed'     => 'boolean',
        'importance_score' => 'integer',
        'duration_seconds' => 'integer',
        'published_at'     => 'datetime',
    ];

    // ─── Relationships ────────────────────────────────────────────

    public function source(): BelongsTo
    {
        return $this->belongsTo(Source::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function stories(): BelongsToMany
    {
        return $this->belongsToMany(Story::class, 'story_video')
            ->withPivot(['relevance_score', 'is_primary'])
            ->withTimestamps();
    }

    public function aiLogs(): MorphMany
    {
        return $this->morphMany(AiLog::class, 'subject');
    }

    // ─── Scopes ───────────────────────────────────────────────────

    public function scopeProcessed($query)
    {
        return $query->where('is_processed', true);
    }

    public function scopeUnprocessed($query)
    {
        return $query->where('is_processed', false);
    }

    public function scopeByPlatform($query, string $platform)
    {
        return $query->where('platform', $platform);
    }

    public function scopeByLanguage($query, string $language)
    {
        return $query->where('language', $language);
    }

    public function scopeRecent($query, int $hours = 24)
    {
        return $query->where('published_at', '>=', now()->subHours($hours));
    }

    // ─── Helpers ──────────────────────────────────────────────────

    public function getAiSummary(string $locale = 'en'): ?string
    {
        return $this->ai_summary[$locale] ?? $this->ai_summary['en'] ?? null;
    }

    public function getFormattedDuration(): string
    {
        if (! $this->duration_seconds) {
            return 'Unknown';
        }

        $hours   = intdiv($this->duration_seconds, 3600);
        $minutes = intdiv($this->duration_seconds % 3600, 60);
        $seconds = $this->duration_seconds % 60;

        if ($hours > 0) {
            return sprintf('%d:%02d:%02d', $hours, $minutes, $seconds);
        }

        return sprintf('%d:%02d', $minutes, $seconds);
    }

    public function getEmbedUrl(): ?string
    {
        if ($this->embed_url) {
            return $this->embed_url;
        }

        if ($this->platform === 'youtube' && $this->external_id) {
            return "https://www.youtube.com/embed/{$this->external_id}";
        }

        return null;
    }

    public function getThumbnailUrl(): ?string
    {
        if ($this->thumbnail_url) {
            return $this->thumbnail_url;
        }

        if ($this->platform === 'youtube' && $this->external_id) {
            return "https://img.youtube.com/vi/{$this->external_id}/maxresdefault.jpg";
        }

        return null;
    }

    public function markAsProcessed(): void
    {
        $this->update(['is_processed' => true]);
    }
}