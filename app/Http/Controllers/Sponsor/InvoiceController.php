<?php

declare(strict_types=1);

namespace App\Http\Controllers\Sponsor;

use App\Http\Controllers\Controller;
use App\Models\Sponsor;
use App\Models\SponsorInvoice;
use App\Services\SponsorFinanceService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InvoiceController extends Controller
{
    public function __construct(
        protected SponsorFinanceService $financeService,
    ) {}

    protected function getSponsor(): ?Sponsor
    {
        return Sponsor::where('user_id', auth()->id())->first();
    }

    public function index(): View
    {
        $sponsor = $this->getSponsor();
        $sponsorId = $sponsor?->id;

        $invoices = $sponsorId
            ? SponsorInvoice::where('sponsor_id', $sponsorId)->with('contract')->latest()->paginate(15)
            : collect(); // no sponsor record yet

        $summary = $sponsorId ? $this->financeService->getInvoiceSummary($sponsorId) : [
            'total_invoiced' => 0, 'total_paid' => 0, 'outstanding' => 0, 'overdue_count' => 0, 'by_status' => collect(),
        ];

        return view('sponsor.invoices.index', compact('invoices', 'summary'));
    }

    public function show(SponsorInvoice $invoice): View
    {
        $sponsor = $this->getSponsor();
        if (! $sponsor || $invoice->sponsor_id !== $sponsor->id) {
            abort(403);
        }

        $invoice->load(['items', 'transactions', 'contract', 'event']);

        return view('sponsor.invoices.show', compact('invoice'));
    }

    public function pay(Request $request, SponsorInvoice $invoice): RedirectResponse
    {
        $sponsor = $this->getSponsor();
        if (! $sponsor || $invoice->sponsor_id !== $sponsor->id) {
            abort(403);
        }

        if (in_array($invoice->status, ['paid', 'cancelled', 'refunded'])) {
            return back()->with('error', 'Invoice cannot be paid.');
        }

        $validated = $request->validate([
            'amount' => 'required|numeric|min:1|max:'.$invoice->balance_due,
            'gateway' => 'required|string|max:50',
            'transaction_id' => 'required|string|max:200',
        ]);

        $this->financeService->recordPayment($invoice, $validated);

        return redirect()->route('sponsor.invoices.show', $invoice)
            ->with('success', 'Payment recorded.');
    }
}
