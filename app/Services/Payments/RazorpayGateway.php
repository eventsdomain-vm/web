<?php

declare(strict_types=1);

namespace App\Services\Payments;

use App\Models\Payment;
use Illuminate\Http\Request;
use Razorpay\Api\Api;
use RuntimeException;

/**
 * Razorpay adapter. Uses the razorpay/razorpay SDK when installed; all SDK
 * access is guarded so the application boots even before `composer require
 * razorpay/razorpay` has run (isConfigured() simply returns false).
 */
class RazorpayGateway implements PaymentGateway
{
    private ?string $key;

    private ?string $secret;

    private ?string $webhookSecret;

    public function __construct()
    {
        $this->key = config('services.razorpay.key');
        $this->secret = config('services.razorpay.secret');
        $this->webhookSecret = config('services.razorpay.webhook_secret');
    }

    public function name(): string
    {
        return 'razorpay';
    }

    public function isConfigured(): bool
    {
        return ! empty($this->key)
            && ! empty($this->secret)
            && class_exists(Api::class);
    }

    public function createOrder(Payment $payment): array
    {
        $this->guard();

        $api = new Api($this->key, $this->secret);

        // Razorpay works in the smallest currency unit (paise for INR).
        $order = $api->order->create([
            'receipt' => $payment->uuid,
            'amount' => (int) round(((float) $payment->amount) * 100),
            'currency' => $payment->currency,
            'notes' => [
                'payment_uuid' => $payment->uuid,
                'payable_type' => (string) $payment->payable_type,
                'payable_id' => (string) $payment->payable_id,
            ],
        ]);

        $payment->update(['gateway_order_id' => $order['id']]);

        return [
            'gateway' => 'razorpay',
            'key' => $this->key,
            'order_id' => $order['id'],
            'amount' => (int) round(((float) $payment->amount) * 100),
            'currency' => $payment->currency,
            'name' => config('app.name'),
            'prefill' => [
                'name' => $payment->user?->name,
                'email' => $payment->user?->email,
            ],
        ];
    }

    public function verifySignature(array $payload): bool
    {
        $this->guard();

        $orderId = $payload['razorpay_order_id'] ?? null;
        $paymentId = $payload['razorpay_payment_id'] ?? null;
        $signature = $payload['razorpay_signature'] ?? null;

        if (! $orderId || ! $paymentId || ! $signature) {
            return false;
        }

        $expected = hash_hmac('sha256', $orderId.'|'.$paymentId, (string) $this->secret);

        return hash_equals($expected, $signature);
    }

    public function parseWebhook(Request $request): array
    {
        $body = $request->getContent();
        $signature = $request->header('X-Razorpay-Signature', '');

        $valid = false;
        if (! empty($this->webhookSecret) && $signature) {
            $expected = hash_hmac('sha256', $body, $this->webhookSecret);
            $valid = hash_equals($expected, $signature);
        }

        $data = $request->json()->all();
        $event = $data['event'] ?? '';
        $entity = $data['payload']['payment']['entity'] ?? [];

        $status = match ($event) {
            'payment.captured', 'order.paid' => 'paid',
            'payment.failed' => 'failed',
            default => 'pending',
        };

        return [
            'event' => $event,
            'order_id' => $entity['order_id'] ?? null,
            'payment_id' => $entity['id'] ?? null,
            'status' => $status,
            'valid' => $valid,
        ];
    }

    private function guard(): void
    {
        if (! $this->isConfigured()) {
            throw new RuntimeException(
                'Razorpay is not configured. Set RAZORPAY_KEY/RAZORPAY_SECRET and run '
                .'`composer require razorpay/razorpay`.'
            );
        }
    }
}
