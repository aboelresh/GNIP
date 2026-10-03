<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClaimSource extends Model
{
    protected $fillable = [
        'claim_id',
        'article_id',
        'stance',
        'excerpt',
    ];

    // ─── Relationships ────────────────────────────────────────────

    public function claim(): BelongsTo
    {
        return $this->belongsTo(Claim::class);
    }

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }
}