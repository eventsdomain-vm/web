<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

/**
 * Admin oversight of payments. v1 is view/mark only — an admin can inspect
 * transactions and manually set the status (e.g. mark a refund that was issued
 * out-of-band); no live gateway refund call is made here.
 */
class AdminPaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Payment::with(['user', 'payable']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('gateway')) {
            $query->where('gateway', $request->gateway);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('uuid', 'like', "%{$search}%")
                    ->orWhere('gateway_payment_id', 'like', "%{$search}%")
                    ->orWhere('gateway_order_id', 'like', "%{$search}%")
                    ->orWhereHas('user', fn ($u) => $u->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%"));
            });
        }

        $payments = $query->latest()->paginate(20)->withQueryString();

        $totals = [
            'paid' => Payment::paid()->sum('amount'),
            'count_paid' => Payment::paid()->count(),
            'count_pending' => Payment::pending()->count(),
        ];

        return view('admin.payments.index', compact('payments', 'totals'));
    }

    public function show(Payment $payment)
    {
        $payment->load(['user', 'payable.event', 'payable.package']);

        return view('admin.payments.show', compact('payment'));
    }

    /**
     * Manually set a payment status (view/mark only — no gateway call).
     */
    public function updateStatus(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'status' => 'required|in:paid,failed,refunded',
        ]);

        match ($validated['status']) {
            'refunded' => $payment->markRefunded(),
            'failed' => $payment->markFailed(),
            'paid' => $payment->markPaid(),
        };

        return redirect()->route('admin.payments.show', $payment)
            ->with('success', "Payment marked as {$validated['status']}.");
    }
}
