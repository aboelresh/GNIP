<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Source extends Model
{
        use HasFactory;
    protected $fillable = [
        'name',
        'slug',
        'website_url',
        'feed_url',
        'feed_type',
        'country_code',
        'language',
        'logo_url',
        'bias',
        'type',
        'reliability_score',
        'is_active',
        'is_free',
        'fetch_interval_minutes',
        'last_fetched_at',
        'metadata',
    ];

    protected $casts = [
        'is_active'              => 'boolean',
        'is_free'                => 'boolean',
        'reliability_score'      => 'integer',
        'fetch_interval_minutes' => 'integer',
        'last_fetched_at'        => 'datetime',
        'metadata'               => 'array',
    ];

    // ─── Relationships ────────────────────────────────────────────

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }

    public function videos(): HasMany
    {
        return $this->hasMany(Video::class);
    }

    // ─── Scopes ───────────────────────────────────────────────────

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFree($query)
    {
        return $query->where('is_free', true);
    }

    public function scopeDueForFetch($query)
    {
        return $query->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('last_fetched_at')
                    ->orWhereRaw(
                        'TIMESTAMPDIFF(MINUTE, last_fetched_at, NOW()) >= fetch_interval_minutes'
                    );
            });
    }

    // ─── Helpers ──────────────────────────────────────────────────

    public function markAsFetched(): void
    {
        $this->update(['last_fetched_at' => now()]);
    }

    public function isDueForFetch(): bool
    {
        if (! $this->last_fetched_at) {
            return true;
        }

        $minutesSinceLastFetch = $this->last_fetched_at->diffInMinutes(now());

        return $minutesSinceLastFetch >= $this->fetch_interval_minutes;
    }

    public function getReliabilityLabel(): string
    {
        return match (true) {
            $this->reliability_score >= 80 => 'high',
            $this->reliability_score >= 50 => 'medium',
            default                        => 'low',
        };
    }
}