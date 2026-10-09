<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Entity extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'type',
        'aliases',
        'country_code',
        'image_url',
        'description',
        'metadata',
    ];

    protected $casts = [
        'aliases' => 'array',
        'description' => 'array',
        'metadata' => 'array',
    ];

    // ─── Relationships ────────────────────────────────────────────

    public function articles(): BelongsToMany
    {
        return $this->belongsToMany(Article::class, 'article_entity')
            ->withPivot(['role', 'relevance_score'])
            ->withTimestamps();
    }

    public function stories(): BelongsToMany
    {
        return $this->belongsToMany(Story::class, 'story_entity')
            ->withPivot(['role', 'relevance_score'])
            ->withTimestamps();
    }

    // ─── Scopes ───────────────────────────────────────────────────

    public function scopeByType($query, string $type)
    {
        return $query->where('type', $type);
    }

    public function scopePersons($query)
    {
        return $query->where('type', 'person');
    }

    public function scopeCountries($query)
    {
        return $query->where('type', 'country');
    }

    public function scopeOrganizations($query)
    {
        return $query->where('type', 'organization');
    }

    // ─── Helpers ──────────────────────────────────────────────────

    public function getTranslatedDescription(string $locale = 'en'): ?string
    {
        return $this->description[$locale] ?? $this->description['en'] ?? null;
    }

    public function hasAlias(string $alias): bool
    {
        if (! $this->aliases) {
            return false;
        }

        return in_array(
            strtolower($alias),
            array_map('strtolower', $this->aliases)
        );
    }

    public function getAllNames(): array
    {
        $names = [$this->name];

        if ($this->aliases) {
            $names = array_merge($names, $this->aliases);
        }

        return array_unique($names);
    }
}
