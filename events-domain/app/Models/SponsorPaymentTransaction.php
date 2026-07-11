<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SponsorPaymentTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'invoice_id',
        'schedule_id',
        'sponsor_id',
        'transaction_id',
        'gateway',
        'type',
        'amount',
        'currency',
        'status',
        'gateway_response',
        'failure_reason',
        'settled_at',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'gateway_response' => 'array',
            'settled_at' => 'timestamp',
        ];
    }

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(SponsorInvoice::class, 'invoice_id');
    }

    public function schedule(): BelongsTo
    {
        return $this->belongsTo(SponsorPaymentSchedule::class, 'schedule_id');
    }

    public function sponsor(): BelongsTo
    {
        return $this->belongsTo(Sponsor::class, 'sponsor_id');
    }

    public function isSuccessful(): bool
    {
        return $this->status === 'success';
    }
}
