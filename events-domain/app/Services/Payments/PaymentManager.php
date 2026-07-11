<?php

declare(strict_types=1);

namespace App\Services\Payments;

use InvalidArgumentException;

/**
 * Single entry point controllers use to reach the active payment gateway.
 * Resolves the configured default (services.payments.default) and can hand back
 * a specific gateway by name (used by the webhook route's {gateway} segment).
 */
class PaymentManager
{
    /** @var array<string, class-string<PaymentGateway>> */
    private array $gateways = [
        'razorpay' => RazorpayGateway::class,
        'stripe' => StripeGateway::class,
    ];

    public function gateway(?string $name = null): PaymentGateway
    {
        $name = $name ?: (string) config('services.payments.default', 'razorpay');

        if (! isset($this->gateways[$name])) {
            throw new InvalidArgumentException("Unknown payment gateway [{$name}].");
        }

        return app($this->gateways[$name]);
    }

    /** The default gateway's machine name. */
    public function defaultName(): string
    {
        return (string) config('services.payments.default', 'razorpay');
    }

    /**
     * Split a pre-tax base amount into base/tax/total using the configured GST
     * rate. When no GST number applies, callers can pass $applyGst=false to
     * skip tax entirely.
     *
     * @return array{base: float, tax: float, total: float, rate: float}
     */
    public function computeGst(float $baseAmount, bool $applyGst = true): array
    {
        $rate = $applyGst ? (float) config('services.payments.gst_rate', 18) : 0.0;
        $tax = round($baseAmount * $rate / 100, 2);

        return [
            'base' => round($baseAmount, 2),
            'tax' => $tax,
            'total' => round($baseAmount + $tax, 2),
            'rate' => $rate,
        ];
    }
}
