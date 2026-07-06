<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PartnerBid extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'partner_id',
        'service_id',
        'quote_amount',
        'quote_note',
        'status',
    ];

    protected $casts = [
        'quote_amount' => 'decimal:2',
    ];

    // =========================================================================
    // Relationships
    // =========================================================================

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function partner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'partner_id');
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(PartnerService::class, 'service_id');
    }

    // =========================================================================
    // Scopes
    // =========================================================================

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeForEvent($query, int $eventId)
    {
        return $query->where('event_id', $eventId);
    }

    public function scopeForPartner($query, int $partnerId)
    {
        return $query->where('partner_id', $partnerId);
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
            'withdrawn' => 'Withdrawn',
            default => ucfirst($this->status),
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'yellow',
            'accepted' => 'green',
            'rejected' => 'red',
            'withdrawn' => 'gray',
            default => 'gray',
        };
    }

    public function getFormattedPriceAttribute(): string
    {
        return '₹'.number_format($this->quote_amount, 0);
    }
}
