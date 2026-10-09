<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'role' => 'string',
    ];

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isUser(): bool
    {
        return $this->role === 'user';
    }

    public function sourcePreferences(): HasMany
    {
        return $this->hasMany(UserSourcePreference::class);
    }

    public function preferredSources(): BelongsToMany
    {
        return $this->belongsToMany(Source::class, 'user_source_preferences')
            ->withPivot('is_enabled')
            ->withTimestamps();
    }

    public function enabledSourceIds(): array
    {
        $disabledIds = $this->sourcePreferences()
            ->where('is_enabled', false)
            ->pluck('source_id')
            ->toArray();

        if (empty($disabledIds)) {
            return [];
        }

        return Source::whereNotIn('id', $disabledIds)
            ->where('is_active', true)
            ->pluck('id')
            ->toArray();
    }

    public function hasSourcePreferences(): bool
    {
        return $this->sourcePreferences()->exists();
    }
}
