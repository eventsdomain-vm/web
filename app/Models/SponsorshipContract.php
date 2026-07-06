<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SponsorshipContract extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'sponsor_id',
        'event_id',
        'request_id',
        'contract_number',
        'title',
        'type',
        'status',
        'terms',
        'amount',
        'currency',
        'clauses',
        'signed_pdf_path',
        'start_date',
        'end_date',
        'signed_at',
        'expires_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'clauses' => 'array',
        'start_date' => 'date',
        'end_date' => 'date',
        'signed_at' => 'timestamp',
        'expires_at' => 'timestamp',
    ];

    // =========================================================================
    // Relationships
    // =========================================================================

    public function sponsor(): BelongsTo
    {
        return $this->belongsTo(Sponsor::class, 'sponsor_id');
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function request(): BelongsTo
    {
        return $this->belongsTo(SponsorshipRequest::class, 'request_id');
    }

    public function versions(): HasMany
    {
        return $this->hasMany(SponsorContractVersion::class, 'contract_id');
    }

    public function amendments(): HasMany
    {
        return $this->hasMany(SponsorContractAmendment::class, 'contract_id');
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(SponsorInvoice::class, 'contract_id');
    }

    public function paymentSchedules(): HasMany
    {
        return $this->hasMany(SponsorPaymentSchedule::class, 'contract_id');
    }

    // =========================================================================
    // Scopes
    // =========================================================================

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopePendingApproval($query)
    {
        return $query->where('status', 'pending_approval');
    }

    public function scopePendingSignature($query)
    {
        return $query->where('status', 'pending_signature');
    }

    // =========================================================================
    // Helpers
    // =========================================================================

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'draft' => 'Draft',
            'pending_approval' => 'Pending Approval',
            'pending_signature' => 'Pending Signature',
            'active' => 'Active',
            'completed' => 'Completed',
            'terminated' => 'Terminated',
            'expired' => 'Expired',
            default => ucfirst($this->status),
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'draft' => 'gray',
            'pending_approval' => 'yellow',
            'pending_signature' => 'blue',
            'active' => 'green',
            'completed' => 'green',
            'terminated' => 'red',
            'expired' => 'orange',
            default => 'gray',
        };
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function isSigned(): bool
    {
        return $this->signed_at !== null;
    }

    public function terminate(): void
    {
        $this->update(['status' => 'terminated']);
    }

    public function complete(): void
    {
        $this->update(['status' => 'completed']);
    }

    public function sign(): void
    {
        $this->update(['status' => 'active', 'signed_at' => now()]);
    }
}
