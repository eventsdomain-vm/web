<?php

declare(strict_types=1);

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\PartnerDeal;
use App\Models\PartnerLead;
use App\Services\Partner\PartnerDealService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DealController extends Controller
{
    public function __construct(
        protected PartnerDealService $dealService,
    ) {}

    public function index(Request $request)
    {
        $partnerId = Auth::id();
        $deals = $this->dealService->list($partnerId, $request->only(['stage', 'search']));
        $stages = ['qualification', 'proposal', 'negotiation', 'contract', 'payment', 'active', 'completed', 'lost'];

        return view('partner.deals.index', compact('deals', 'stages'));
    }

    public function create()
    {
        $leads = PartnerLead::where('partner_id', Auth::id())
            ->where('stage', 'won')
            ->whereDoesntHave('deal')
            ->get();

        return view('partner.deals.create', compact('leads'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'lead_id' => 'nullable|exists:partner_leads,id',
            'sponsor_id' => 'nullable|exists:sponsors,id',
            'event_id' => 'nullable|exists:events,id',
            'stage' => 'required|string|max:30',
            'deal_value' => 'nullable|numeric|min:0',
            'commission_rate' => 'nullable|numeric|min:0|max:100',
            'expected_close_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        $this->dealService->create(Auth::id(), $validated);

        return redirect()->route('partner.deals.index')->with('success', 'Deal created.');
    }

    public function show(int $id)
    {
        $deal = PartnerDeal::with(['sponsor', 'event', 'lead', 'commissions', 'meetings'])
            ->where('partner_id', Auth::id())
            ->findOrFail($id);

        return view('partner.deals.show', compact('deal'));
    }

    public function updateStage(Request $request, int $id)
    {
        $validated = $request->validate([
            'stage' => 'required|string|max:30',
            'lost_reason' => 'nullable|string|max:255',
        ]);

        $deal = PartnerDeal::where('partner_id', Auth::id())->findOrFail($id);
        $this->dealService->updateStage($deal, $validated['stage']);

        return redirect()->route('partner.deals.index')->with('success', 'Deal stage updated.');
    }
}
