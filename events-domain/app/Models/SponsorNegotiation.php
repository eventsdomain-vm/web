<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SponsorNegotiation extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'request_id',
        'initiated_by',
        'status',
        'current_offer',
        'currency',
        'terms_summary',
        'expires_at',
        'accepted_at',
    ];

    protected function casts(): array
    {
        return [
            'current_offer' => 'decimal:2',
            'expires_at' => 'timestamp',
            'accepted_at' => 'timestamp',
        ];
    }

    public function request(): BelongsTo
    {
        return $this->belongsTo(SponsorshipRequest::class, 'request_id');
    }

    public function initiator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'initiated_by');
    }

    public function rounds(): HasMany
    {
        return $this->hasMany(SponsorNegotiationRound::class, 'negotiation_id');
    }

    public function isOpen(): bool
    {
        return $this->status === 'open';
    }

    public function accept(): void
    {
        $this->update(['status' => 'accepted', 'accepted_at' => now()]);
    }

    public function decline(): void
    {
        $this->update(['status' => 'declined']);
    }
}
