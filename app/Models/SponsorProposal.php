<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class SponsorProposal extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'sponsor_id',
        'package_id',
        'status',
        'message',
        'budget_offer',
        'additional_benefits',
        'internal_note',
        'organizer_note',
        'counter_amount',
        'counter_message',
        'viewed_at',
        'agreed_at',
        'contracted_at',
        'completed_at',
    ];

    protected function casts(): array
    {
        return [
            'budget_offer' => 'decimal:2',
            'counter_amount' => 'decimal:2',
            'viewed_at' => 'datetime',
            'agreed_at' => 'datetime',
            'contracted_at' => 'datetime',
            'completed_at' => 'datetime',
        ];
    }

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

    public function campaign(): HasOne
    {
        return $this->hasOne(SponsorCampaign::class, 'proposal_id');
    }

    public function scopePending($query)
    {
        return $query->whereIn('status', ['submitted', 'viewed', 'shortlisted']);
    }

    public function scopeNegotiating($query)
    {
        return $query->whereIn('status', ['negotiating', 'counter_offer']);
    }

    public function scopeActive($query)
    {
        return $query->whereIn('status', ['agreed', 'contracted', 'payment_pending', 'active']);
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'draft' => 'Draft',
            'submitted' => 'Submitted',
            'viewed' => 'Viewed',
            'shortlisted' => 'Shortlisted',
            'negotiating' => 'Negotiating',
            'counter_offer' => 'Counter Offer',
            'agreed' => 'Agreed',
            'contracted' => 'Contracted',
            'payment_pending' => 'Payment Pending',
            'active' => 'Active',
            'completed' => 'Completed',
            'rejected' => 'Rejected',
            'withdrawn' => 'Withdrawn',
            default => ucfirst($this->status),
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'draft' => 'gray',
            'submitted', 'viewed', 'shortlisted' => 'blue',
            'negotiating', 'counter_offer' => 'yellow',
            'agreed' => 'indigo',
            'contracted' => 'purple',
            'payment_pending' => 'orange',
            'active' => 'green',
            'completed' => 'emerald',
            'rejected' => 'red',
            'withdrawn' => 'gray',
            default => 'gray',
        };
    }

    public function accept(): void
    {
        $this->update(['status' => 'agreed', 'agreed_at' => now()]);
    }

    public function reject(): void
    {
        $this->update(['status' => 'rejected']);
    }

    public function markViewed(): void
    {
        if ($this->status === 'submitted') {
            $this->update(['status' => 'viewed', 'viewed_at' => now()]);
        }
    }
}
