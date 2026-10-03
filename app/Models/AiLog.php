<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class AiLog extends Model
{
    protected $fillable = [
        'provider',
        'model',
        'operation',
        'subject_type',
        'subject_id',
        'status',
        'prompt_tokens',
        'completion_tokens',
        'total_tokens',
        'duration_seconds',
        'cost',
        'error_message',
        'metadata',
    ];

    protected $casts = [
        'prompt_tokens'     => 'integer',
        'completion_tokens' => 'integer',
        'total_tokens'      => 'integer',
        'duration_seconds'  => 'float',
        'cost'              => 'float',
        'metadata'          => 'array',
    ];

    // ─── Relationships ────────────────────────────────────────────

    public function subject(): MorphTo
    {
        return $this->morphTo();
    }

    // ─── Scopes ───────────────────────────────────────────────────

    public function scopeSuccessful($query)
    {
        return $query->where('status', 'success');
    }

    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    public function scopeByProvider($query, string $provider)
    {
        return $query->where('provider', $provider);
    }

    public function scopeByOperation($query, string $operation)
    {
        return $query->where('operation', $operation);
    }

    // ─── Helpers ──────────────────────────────────────────────────

    public function getTotalTokensFormatted(): string
    {
        return number_format($this->total_tokens);
    }

    public function getDurationFormatted(): string
    {
        return round($this->duration_seconds, 2) . 's';
    }

    // ─── Static Helpers ───────────────────────────────────────────

    public static function getUsageStats(string $provider = null): array
    {
        $query = static::successful();

        if ($provider) {
            $query->byProvider($provider);
        }

        return [
            'total_requests'    => $query->count(),
            'total_tokens'      => $query->sum('total_tokens'),
            'total_cost'        => $query->sum('cost'),
            'avg_duration'      => round($query->avg('duration_seconds'), 2),
            'failed_requests'   => static::failed()->when($provider, fn($q) => $q->byProvider($provider))->count(),
        ];
    }
}