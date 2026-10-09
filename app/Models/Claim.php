<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Claim extends Model
{
    protected $fillable = [
        'story_id',
        'text',
        'status',
        'importance',
        'confirmed_by_count',
        'disputed_by_count',
        'mentioned_by_count',
        'metadata',
    ];

    protected $casts = [
        'text' => 'array',
        'metadata' => 'array',
        'confirmed_by_count' => 'integer',
        'disputed_by_count' => 'integer',
        'mentioned_by_count' => 'integer',
    ];

    // ─── Relationships ────────────────────────────────────────────

    public function story(): BelongsTo
    {
        return $this->belongsTo(Story::class);
    }

    public function claimSources(): HasMany
    {
        return $this->hasMany(ClaimSource::class);
    }

    public function confirmingSources()
    {
        return $this->claimSources()->where('stance', 'confirms');
    }

    public function disputingSources()
    {
        return $this->claimSources()->where('stance', 'disputes');
    }

    // ─── Scopes ───────────────────────────────────────────────────

    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    public function scopeUnverified($query)
    {
        return $query->where('status', 'unverified');
    }

    public function scopeDisputed($query)
    {
        return $query->where('status', 'disputed');
    }

    public function scopeCritical($query)
    {
        return $query->where('importance', 'critical');
    }

    // ─── Helpers ──────────────────────────────────────────────────

    public function getTranslatedText(string $locale = 'en'): string
    {
        return $this->text[$locale] ?? $this->text['en'] ?? '';
    }

    public function recalculateCounts(): void
    {
        $this->update([
            'confirmed_by_count' => $this->claimSources()->where('stance', 'confirms')->count(),
            'disputed_by_count' => $this->claimSources()->where('stance', 'disputes')->count(),
            'mentioned_by_count' => $this->claimSources()->where('stance', 'mentions')->count(),
        ]);
    }

    public function updateStatus(): void
    {
        $status = match (true) {
            $this->confirmed_by_count >= 3 && $this->disputed_by_count === 0 => 'confirmed',
            $this->disputed_by_count >= 2 => 'disputed',
            $this->confirmed_by_count >= 1 && $this->disputed_by_count >= 1 => 'partially_confirmed',
            default => 'unverified',
        };

        $this->update(['status' => $status]);
    }
}
