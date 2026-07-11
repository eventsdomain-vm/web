<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SponsorPaymentSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'contract_id',
        'installment_number',
        'amount',
        'currency',
        'due_date',
        'status',
        'paid_at',
        'invoice_id',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'due_date' => 'date',
            'paid_at' => 'timestamp',
        ];
    }

    public function contract(): BelongsTo
    {
        return $this->belongsTo(SponsorshipContract::class, 'contract_id');
    }

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(SponsorInvoice::class, 'invoice_id');
    }

    public function isOverdue(): bool
    {
        return $this->status === 'pending' && $this->due_date->isPast();
    }
}
