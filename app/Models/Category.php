<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = [
        'slug',
        'name',
        'description',
        'icon',
        'color',
        'order',
        'is_active',
    ];

    protected $casts = [
        'name' => 'array',
        'description' => 'array',
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    // ─── Relationships ────────────────────────────────────────────

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }

    public function stories(): HasMany
    {
        return $this->hasMany(Story::class);
    }

    public function videos(): HasMany
    {
        return $this->hasMany(Video::class);
    }

    // ─── Helpers ──────────────────────────────────────────────────

    public function getTranslatedName(string $locale = 'en'): string
    {
        return $this->name[$locale] ?? $this->name['en'] ?? '';
    }

    public function getTranslatedDescription(string $locale = 'en'): ?string
    {
        return $this->description[$locale] ?? $this->description['en'] ?? null;
    }

    // ─── Scopes ───────────────────────────────────────────────────

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }
}
