<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class SponsorInvoice extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'uuid',
        'contract_id',
        'sponsor_id',
        'event_id',
        'invoice_number',
        'status',
        'issue_date',
        'due_date',
        'subtotal',
        'tax_rate',
        'tax_amount',
        'discount',
        'total',
        'amount_paid',
        'currency',
        'notes',
        'terms',
        'pdf_path',
        'sent_at',
        'paid_at',
    ];

    protected function casts(): array
    {
        return [
            'issue_date' => 'date',
            'due_date' => 'date',
            'subtotal' => 'decimal:2',
            'tax_rate' => 'decimal:2',
            'tax_amount' => 'decimal:2',
            'discount' => 'decimal:2',
            'total' => 'decimal:2',
            'amount_paid' => 'decimal:2',
            'sent_at' => 'timestamp',
            'paid_at' => 'timestamp',
        ];
    }

    public function contract(): BelongsTo
    {
        return $this->belongsTo(SponsorshipContract::class, 'contract_id');
    }

    public function sponsor(): BelongsTo
    {
        return $this->belongsTo(Sponsor::class, 'sponsor_id');
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(SponsorInvoiceItem::class, 'invoice_id');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(SponsorPaymentTransaction::class, 'invoice_id');
    }

    public function getBalanceDueAttribute(): float
    {
        return (float) ($this->total - $this->amount_paid);
    }

    public function isOverdue(): bool
    {
        return $this->status !== 'paid' && $this->status !== 'cancelled' && $this->due_at->isPast();
    }

    public function scopeOverdue($query)
    {
        return $query->whereNotIn('status', ['paid', 'cancelled', 'refunded'])
            ->where('due_date', '<', now());
    }
}
