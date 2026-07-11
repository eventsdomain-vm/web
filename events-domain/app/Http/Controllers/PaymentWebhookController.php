<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\SponsorshipRequest;
use App\Services\Payments\PaymentManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Receives gateway webhooks (server-to-server). This is the authoritative
 * source of truth for a payment reaching `paid` — it runs even if the browser
 * callback is lost. Signature is verified per-gateway; updates are idempotent.
 */
class PaymentWebhookController extends Controller
{
    public function __construct(private PaymentManager $payments) {}

    public function handle(Request $request, string $gateway): JsonResponse
    {
        try {
            $adapter = $this->payments->gateway($gateway);
        } catch (\Throwable $e) {
            return response()->json(['ok' => false, 'error' => 'unknown gateway'], 404);
        }

        $parsed = $adapter->parseWebhook($request);

        if (! ($parsed['valid'] ?? false)) {
            Log::warning('Payment webhook signature invalid', ['gateway' => $gateway]);

            return response()->json(['ok' => false, 'error' => 'invalid signature'], 400);
        }

        $payment = null;
        if (! empty($parsed['order_id'])) {
            $payment = Payment::where('gateway_order_id', $parsed['order_id'])->first();
        }

        if (! $payment) {
            // Acknowledge so the gateway stops retrying; nothing to reconcile.
            return response()->json(['ok' => true, 'note' => 'no matching payment']);
        }

        DB::transaction(function () use ($payment, $parsed) {
            if (($parsed['status'] ?? null) === 'paid') {
                $justPaid = $payment->markPaid($parsed['payment_id'] ?? null);
                if ($justPaid) {
                    $this->confirmPayable($payment);
                }
            } elseif (($parsed['status'] ?? null) === 'failed') {
                $payment->markFailed();
            }
        });

        return response()->json(['ok' => true]);
    }

    private function confirmPayable(Payment $payment): void
    {
        $payable = $payment->payable;

        if ($payable instanceof SponsorshipRequest && $payable->status !== 'accepted') {
            $payable->accept();
        }
    }
}
