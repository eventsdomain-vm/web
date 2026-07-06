<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OtpVerification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'otp_code',
        'channel',
        'expires_at',
        'attempts',
        'verified_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'verified_at' => 'datetime',
        'attempts' => 'integer',
    ];

    // =========================================================================
    // Relationships
    // =========================================================================

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // =========================================================================
    // Helpers
    // =========================================================================

    public function isExpired(): bool
    {
        return $this->expires_at->isPast();
    }

    public function hasReachedMaxAttempts(): bool
    {
        return $this->attempts >= 3;
    }

    public function verify(string $code): bool
    {
        if ($this->isExpired() || $this->hasReachedMaxAttempts()) {
            return false;
        }

        if ($this->otp_code !== $code) {
            $this->increment('attempts');

            return false;
        }

        $this->update(['verified_at' => now()]);

        return true;
    }
}
