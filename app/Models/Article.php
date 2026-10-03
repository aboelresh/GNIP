<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Article extends Model
{
    use HasFactory;
    protected $fillable = [
        'source_id',
        'category_id',
        'external_id',
        'url',
        'title',
        'original_title',
        'description',
        'content',
        'author',
        'image_url',
        'language',
        'country_code',
        'published_at',
        'status',
        'content_hash',
        'is_duplicate',
        'duplicate_of',
        'importance_score',
        'ai_summary',
        'ai_categories',
        'metadata',
    ];

    protected $casts = [
        'published_at'     => 'datetime',
        'is_duplicate'     => 'boolean',
        'importance_score' => 'integer',
        'ai_summary'       => 'array',
        'ai_categories'    => 'array',
        'metadata'         => 'array',
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
        return $this->belongsToMany(Story::class, 'story_articles')
            ->withPivot(['is_primary', 'relevance_score', 'perspective', 'key_points'])
            ->withTimestamps();
    }

    public function entities(): BelongsToMany
    {
        return $this->belongsToMany(Entity::class, 'article_entity')
            ->withPivot(['role', 'relevance_score'])
            ->withTimestamps();
    }

    public function claimSources(): HasMany
    {
        return $this->hasMany(ClaimSource::class);
    }

    public function aiLogs(): MorphMany
    {
        return $this->morphMany(AiLog::class, 'subject');
    }

    // ─── Scopes ───────────────────────────────────────────────────

    public function scopeRaw($query)
    {
        return $query->where('status', 'raw');
    }

    public function scopeProcessed($query)
    {
        return $query->where('status', 'processed');
    }

    public function scopeNotDuplicate($query)
    {
        return $query->where('is_duplicate', false);
    }

    public function scopeByLanguage($query, string $language)
    {
        return $query->where('language', $language);
    }

    public function scopeRecent($query, int $hours = 24)
    {
        return $query->where('published_at', '>=', now()->subHours($hours));
    }

    public function scopeByCountry($query, string $countryCode)
    {
        return $query->where('country_code', $countryCode);
    }

    // ─── Helpers ──────────────────────────────────────────────────

    public function markAsProcessed(): void
    {
        $this->update(['status' => 'processed']);
    }

    public function markAsFailed(): void
    {
        $this->update(['status' => 'failed']);
    }

    public function markAsProcessing(): void
    {
        $this->update(['status' => 'processing']);
    }

    public function markAsDuplicate(int $originalId): void
    {
        $this->update([
            'is_duplicate' => true,
            'duplicate_of' => $originalId,
            'status'       => 'processed',
        ]);
    }

    public function getAiSummary(string $locale = 'en'): ?string
    {
        return $this->ai_summary[$locale] ?? $this->ai_summary['en'] ?? null;
    }

    public function generateContentHash(): string
    {
        $content = strtolower(trim($this->title . ' ' . $this->description));
        return hash('sha256', $content);
    }
}