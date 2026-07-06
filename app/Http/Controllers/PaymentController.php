<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\SponsorshipRequest;
use App\Services\Payments\PaymentManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Sponsor-facing checkout. A sponsor pays for a sponsorship request they own;
 * a successful payment confirms the request (accept()) and records a Payment.
 * The gateway is resolved through PaymentManager so this controller stays
 * gateway-agnostic.
 */
class PaymentController extends Controller
{
    public function __construct(private PaymentManager $payments) {}

    /**
     * Show the order summary + create a gateway order for a sponsorship request.
     */
    public function checkout(SponsorshipRequest $sponsorshipRequest)
    {
        $this->authorizeOwner($sponsorshipRequest);

        $sponsorshipRequest->load('event', 'package');

        $package = $sponsorshipRequest->package;
        abort_if(! $package, 404, 'This request has no package to pay for.');

        // Prefer the negotiated offer if present, else the package list price.
        $baseAmount = (float) ($sponsorshipRequest->budget_offer ?: $package->price);

        // GST applies when the payer has a verified GSTIN on their profile.
        $profile = auth()->user()->profile;
        $gstNumber = $profile?->gst_verified ? $profile->gst_number : null;
        $gst = $this->payments->computeGst($baseAmount, applyGst: (bool) $gstNumber);

        // Reuse an existing unpaid payment for this request, else create one.
        $payment = Payment::where('payable_type', SponsorshipRequest::class)
            ->where('payable_id', $sponsorshipRequest->id)
            ->whereIn('status', ['created', 'pending'])
            ->latest()
            ->first();

        if (! $payment) {
            $payment = new Payment([
                'user_id' => auth()->id(),
                'gateway' => $this->payments->defaultName(),
                'currency' => $package->currency ?: config('services.payments.currency', 'INR'),
                'status' => 'created',
            ]);
            $payment->payable()->associate($sponsorshipRequest);
        }

        $payment->fill([
            'amount' => $gst['total'],
            'base_amount' => $gst['base'],
            'tax_amount' => $gst['tax'],
            'gst_number' => $gstNumber,
        ])->save();

        $gateway = $this->payments->gateway($payment->gateway);

        $checkout = null;
        $error = null;
        if ($gateway->isConfigured()) {
            try {
                $checkout = $gateway->createOrder($payment);
            } catch (\Throwable $e) {
                $error = $e->getMessage();
            }
        } else {
            $error = 'Payment gateway is not configured yet. Add API keys to enable checkout.';
        }

        return view('payments.checkout', [
            'payment' => $payment,
            'request' => $sponsorshipRequest,
            'package' => $package,
            'gst' => $gst,
            'checkout' => $checkout,
            'error' => $error,
        ]);
    }

    /**
     * Browser return URL after the gateway collects payment. Verifies the
     * signature, marks the payment paid and confirms the sponsorship request.
     * The webhook is the authoritative backup if this callback is lost.
     */
    public function callback(Request $request, Payment $payment)
    {
        $this->authorizeOwner($payment->payable);

        $gateway = $this->payments->gateway($payment->gateway);

        if (! $gateway->verifySignature($request->all())) {
            $payment->markFailed();

            return redirect()->route('payments.receipt', $payment)
                ->with('error', 'Payment verification failed. If you were charged, it will be reconciled shortly.');
        }

        DB::transaction(function () use ($payment, $request) {
            $justPaid = $payment->markPaid(
                $request->input('razorpay_payment_id'),
                $request->input('razorpay_signature'),
            );

            if ($justPaid) {
                $this->confirmPayable($payment);
            }
        });

        return redirect()->route('payments.receipt', $payment)
            ->with('success', 'Payment successful. Your sponsorship is confirmed!');
    }

    /**
     * Receipt / status page for a payment the sponsor owns.
     */
    public function receipt(Payment $payment)
    {
        $this->authorizeOwner($payment->payable);

        $payment->load('payable.event', 'payable.package', 'user');

        return view('payments.receipt', compact('payment'));
    }

    /**
     * On successful payment, confirm the sponsorship request (idempotent).
     */
    private function confirmPayable(Payment $payment): void
    {
        $payable = $payment->payable;

        if ($payable instanceof SponsorshipRequest && $payable->status !== 'accepted') {
            $payable->accept(); // increments package slots_filled
        }
    }

    /**
     * Guard: the authenticated user must own the sponsorship request behind
     * this payment (mirrors Sponsor\RequestController's owner check).
     */
    private function authorizeOwner(?object $payable): void
    {
        $sponsorId = $payable instanceof SponsorshipRequest ? $payable->sponsor_id : null;

        abort_if($sponsorId !== auth()->id(), 403);
    }
}
