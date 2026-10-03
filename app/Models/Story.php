<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Story extends Model
{
    protected $fillable = [
        'category_id',
        'slug',
        'title',
        'summary',
        'what_happened',
        'what_changed',
        'sources_agree',
        'sources_disagree',
        'unconfirmed_claims',
        'evidence_level',
        'evidence_score',
        'sources_count',
        'articles_count',
        'independent_sources_count',
        'importance_score',
        'is_trending',
        'is_published',
        'countries',
        'languages',
        'tags',
        'image_url',
        'first_reported_at',
        'last_updated_at',
        'published_at',
        'metadata',
    ];

    protected $casts = [
        'title'                     => 'array',
        'summary'                   => 'array',
        'what_happened'             => 'array',
        'what_changed'              => 'array',
        'sources_agree'             => 'array',
        'sources_disagree'          => 'array',
        'unconfirmed_claims'        => 'array',
        'countries'                 => 'array',
        'languages'                 => 'array',
        'tags'                      => 'array',
        'metadata'                  => 'array',
        'is_trending'               => 'boolean',
        'is_published'              => 'boolean',
        'evidence_score'            => 'integer',
        'sources_count'             => 'integer',
        'articles_count'            => 'integer',
        'independent_sources_count' => 'integer',
        'importance_score'          => 'integer',
        'first_reported_at'         => 'datetime',
        'last_updated_at'           => 'datetime',
        'published_at'              => 'datetime',
    ];

    // ─── Relationships ────────────────────────────────────────────

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function articles(): BelongsToMany
    {
        return $this->belongsToMany(Article::class, 'story_articles')
            ->withPivot(['is_primary', 'relevance_score', 'perspective', 'key_points'])
            ->withTimestamps();
    }

    public function primaryArticle()
    {
        return $this->articles()->wherePivot('is_primary', true)->first();
    }

    public function entities(): BelongsToMany
    {
        return $this->belongsToMany(Entity::class, 'story_entity')
            ->withPivot(['role', 'relevance_score'])
            ->withTimestamps();
    }

    public function claims(): HasMany
    {
        return $this->hasMany(Claim::class);
    }

    public function videos(): BelongsToMany
    {
        return $this->belongsToMany(Video::class, 'story_video')
            ->withPivot(['relevance_score', 'is_primary'])
            ->withTimestamps();
    }

    public function briefings(): BelongsToMany
    {
        return $this->belongsToMany(Briefing::class, 'briefing_story')
            ->withPivot(['order', 'section', 'summary'])
            ->withTimestamps();
    }

    public function aiLogs(): MorphMany
    {
        return $this->morphMany(AiLog::class, 'subject');
    }

    // ─── Scopes ───────────────────────────────────────────────────

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeTrending($query)
    {
        return $query->where('is_trending', true);
    }

    public function scopeByEvidenceLevel($query, string $level)
    {
        return $query->where('evidence_level', $level);
    }

    public function scopeByCountry($query, string $countryCode)
    {
        return $query->whereJsonContains('countries', $countryCode);
    }

    public function scopeByLanguage($query, string $language)
    {
        return $query->whereJsonContains('languages', $language);
    }

    public function scopeRecent($query, int $hours = 24)
    {
        return $query->where('first_reported_at', '>=', now()->subHours($hours));
    }

    public function scopeTopStories($query, int $limit = 10)
    {
        return $query->published()
            ->orderByDesc('importance_score')
            ->limit($limit);
    }

    // ─── Helpers ──────────────────────────────────────────────────

    public function getTranslatedTitle(string $locale = 'en'): string
    {
        return $this->title[$locale] ?? $this->title['en'] ?? '';
    }

    public function getTranslatedSummary(string $locale = 'en'): ?string
    {
        return $this->summary[$locale] ?? $this->summary['en'] ?? null;
    }

    public function publish(): void
    {
        $this->update([
            'is_published' => true,
            'published_at' => now(),
        ]);
    }

    public function updateEvidenceLevel(): void
    {
        $level = match (true) {
            $this->evidence_score >= 75 => 'high',
            $this->evidence_score >= 45 => 'moderate',
            $this->evidence_score >= 20 => 'low',
            default                     => 'unverified',
        };

        $this->update(['evidence_level' => $level]);
    }

    public function recalculateCounters(): void
    {
        $articles = $this->articles()->notDuplicate()->get();

        $sourceIds = $articles->pluck('source_id')->unique();

        $this->update([
            'articles_count' => $articles->count(),
            'sources_count'  => $sourceIds->count(),
        ]);
    }
}