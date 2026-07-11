<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Payment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'uuid',
        'user_id',
        'payable_type',
        'payable_id',
        'gateway',
        'gateway_order_id',
        'gateway_payment_id',
        'gateway_signature',
        'amount',
        'base_amount',
        'tax_amount',
        'currency',
        'gst_number',
        'status',
        'metadata',
        'paid_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'base_amount' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'metadata' => 'array',
        'paid_at' => 'datetime',
    ];

    // =========================================================================
    // Boot
    // =========================================================================

    public static function boot(): void
    {
        parent::boot();

        static::creating(function ($payment) {
            if (empty($payment->uuid)) {
                $payment->uuid = (string) Str::uuid();
            }
        });
    }

    // =========================================================================
    // Relationships
    // =========================================================================

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function payable(): MorphTo
    {
        return $this->morphTo();
    }

    // =========================================================================
    // Scopes
    // =========================================================================

    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    public function scopePending($query)
    {
        return $query->whereIn('status', ['created', 'pending']);
    }

    public function scopeForGateway($query, string $gateway)
    {
        return $query->where('gateway', $gateway);
    }

    // =========================================================================
    // Helpers
    // =========================================================================

    public function isPaid(): bool
    {
        return $this->status === 'paid';
    }

    /**
     * Mark this payment paid. Idempotent — safe to call from both the browser
     * callback and the webhook; a second call after `paid` is a no-op and
     * returns false so callers can skip post-payment side effects.
     */
    public function markPaid(?string $gatewayPaymentId = null, ?string $signature = null): bool
    {
        if ($this->status === 'paid') {
            return false;
        }

        $this->forceFill([
            'status' => 'paid',
            'gateway_payment_id' => $gatewayPaymentId ?? $this->gateway_payment_id,
            'gateway_signature' => $signature ?? $this->gateway_signature,
            'paid_at' => now(),
        ])->save();

        return true;
    }

    public function markFailed(): void
    {
        if ($this->status !== 'paid') {
            $this->update(['status' => 'failed']);
        }
    }

    public function markRefunded(): void
    {
        $this->update(['status' => 'refunded']);
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'paid' => 'green',
            'created', 'pending' => 'yellow',
            'failed' => 'red',
            'refunded' => 'gray',
            default => 'gray',
        };
    }

    public function getFormattedAmountAttribute(): string
    {
        $symbol = $this->currency === 'INR' ? '₹' : '';

        return $symbol.number_format((float) $this->amount, 2);
    }
}
