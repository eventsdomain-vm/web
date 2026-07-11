<?php

declare(strict_types=1);

namespace App\Services\Payments;

use App\Models\Payment;
use Illuminate\Http\Request;
use RuntimeException;
use Stripe\StripeClient;

/**
 * Stripe adapter — stub. Kept behind the PaymentGateway interface so Stripe can
 * be enabled later by installing stripe/stripe-php and filling in these methods,
 * without touching controllers. Until then isConfigured() returns false and the
 * PaymentManager will not select it.
 */
class StripeGateway implements PaymentGateway
{
    public function name(): string
    {
        return 'stripe';
    }

    public function isConfigured(): bool
    {
        // Requires stripe/stripe-php + keys; not wired up in this build.
        return ! empty(config('services.stripe.secret'))
            && class_exists(StripeClient::class);
    }

    public function createOrder(Payment $payment): array
    {
        throw new RuntimeException('Stripe gateway is not implemented yet.');
    }

    public function verifySignature(array $payload): bool
    {
        return false;
    }

    public function parseWebhook(Request $request): array
    {
        return [
            'event' => '',
            'order_id' => null,
            'payment_id' => null,
            'status' => 'pending',
            'valid' => false,
        ];
    }
}
