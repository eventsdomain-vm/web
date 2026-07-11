<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class SponsorshipRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'sponsor_id',
        'package_id',
        'status',
        'custom_proposal',
        'budget_offer',
        'message',
    ];

    protected $casts = [
        'budget_offer' => 'decimal:2',
    ];

    // =========================================================================
    // Relationships
    // =========================================================================

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function sponsor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sponsor_id');
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(SponsorshipPackage::class, 'package_id');
    }

    public function contract(): HasOne
    {
        return $this->hasOne(SponsorshipContract::class, 'request_id');
    }

    // =========================================================================
    // Scopes
    // =========================================================================

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeAccepted($query)
    {
        return $query->where('status', 'accepted');
    }

    public function scopeForEvent($query, int $eventId)
    {
        return $query->where('event_id', $eventId);
    }

    public function scopeForSponsor($query, int $sponsorId)
    {
        return $query->where('sponsor_id', $sponsorId);
    }

    // =========================================================================
    // Helpers
    // =========================================================================

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'Pending',
            'accepted' => 'Accepted',
            'rejected' => 'Rejected',
            'negotiating' => 'Negotiating',
            default => ucfirst($this->status),
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'yellow',
            'accepted' => 'green',
            'rejected' => 'red',
            'negotiating' => 'blue',
            default => 'gray',
        };
    }

    public function accept(): void
    {
        $this->update(['status' => 'accepted']);

        // Increment slots filled
        if ($this->package) {
            $this->package->increment('slots_filled');
        }
    }

    public function reject(): void
    {
        $this->update(['status' => 'rejected']);
    }
}
