<?php

declare(strict_types=1);

namespace App\Http\Controllers\Sponsor;

use App\Http\Controllers\Controller;
use App\Models\Sponsor;
use App\Models\SponsorshipContract;
use App\Services\SponsorContractService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContractController extends Controller
{
    public function __construct(
        protected SponsorContractService $contractService,
    ) {}

    protected function getSponsorId(): ?int
    {
        return Sponsor::where('user_id', auth()->id())->value('id');
    }

    public function index(): View
    {
        $sponsorId = $this->getSponsorId();

        $contracts = $sponsorId
            ? SponsorshipContract::where('sponsor_id', $sponsorId)
                ->with('event')
                ->latest()
                ->paginate(15)
            : SponsorshipContract::whereHas('request', fn ($q) => $q->where('sponsor_id', auth()->id()))
                ->with('event')
                ->latest()
                ->paginate(15);

        return view('sponsor.contracts.index', compact('contracts'));
    }

    public function show(SponsorshipContract $contract): View
    {
        if (! $this->authorizeContract($contract)) {
            abort(403);
        }

        $contract->load(['event', 'request', 'versions', 'amendments', 'invoices', 'paymentSchedules']);

        $timeline = $this->contractService->getContractTimeline($contract);

        return view('sponsor.contracts.show', compact('contract', 'timeline'));
    }

    public function sign(SponsorshipContract $contract): RedirectResponse
    {
        if (! $this->authorizeContract($contract)) {
            abort(403);
        }

        if ($contract->status !== 'pending_signature') {
            return back()->with('error', 'Contract is not awaiting signature.');
        }

        $this->contractService->signContract($contract, auth()->id());

        return redirect()->route('sponsor.contracts.show', $contract)
            ->with('success', 'Contract signed successfully.');
    }

    public function storeAmendment(Request $request, SponsorshipContract $contract): RedirectResponse
    {
        if (! $this->authorizeContract($contract)) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|in:amendment,addendum,termination',
            'amount_adjustment' => 'nullable|numeric',
            'effective_date' => 'nullable|date',
        ]);

        $this->contractService->createAmendment($contract, $validated);

        return redirect()->route('sponsor.contracts.show', $contract)
            ->with('success', 'Amendment submitted.');
    }

    protected function authorizeContract(SponsorshipContract $contract): bool
    {
        $sponsorId = $this->getSponsorId();

        if ($sponsorId && $contract->sponsor_id === $sponsorId) {
            return true;
        }

        return $contract->request?->sponsor_id === auth()->id();
    }
}
