<?php

declare(strict_types=1);

namespace App\Services\Payments;

use App\Models\Payment;
use Illuminate\Http\Request;

/**
 * Gateway-agnostic contract. Each concrete gateway (Razorpay, Stripe…) adapts
 * its provider SDK to these methods so controllers never touch a provider
 * directly. All money is handled in the Payment's major units (rupees); gateways
 * convert to their own smallest-unit representation internally.
 */
interface PaymentGateway
{
    /**
     * Create an order at the gateway for the given Payment and return the
     * client-side payload the checkout view needs (keys, order id, amount…).
     * Also persists gateway_order_id back onto the Payment.
     *
     * @return array<string,mixed>
     */
    public function createOrder(Payment $payment): array;

    /**
     * Verify a browser-callback signature (the redirect back from the gateway
     * after the user pays). Returns true when the signature is authentic.
     *
     * @param  array<string,mixed>  $payload
     */
    public function verifySignature(array $payload): bool;

    /**
     * Parse an inbound webhook request into a normalized shape:
     *   ['event' => string, 'order_id' => ?string, 'payment_id' => ?string,
     *    'status' => 'paid'|'failed'|'pending', 'valid' => bool]
     * `valid` reflects webhook-signature verification.
     *
     * @return array<string,mixed>
     */
    public function parseWebhook(Request $request): array;

    /** Machine name of this gateway (e.g. "razorpay"). */
    public function name(): string;

    /** Whether this gateway is configured + its SDK available. */
    public function isConfigured(): bool;
}
