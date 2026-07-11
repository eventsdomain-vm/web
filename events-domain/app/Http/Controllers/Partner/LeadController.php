<?php

declare(strict_types=1);

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\PartnerLead;
use App\Services\Partner\PartnerLeadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeadController extends Controller
{
    public function __construct(
        protected PartnerLeadService $leadService,
    ) {}

    public function index(Request $request)
    {
        $partnerId = Auth::id();
        $leads = $this->leadService->list($partnerId, $request->only(['stage', 'priority', 'source', 'search']));
        $stages = ['new', 'contacted', 'qualified', 'proposal', 'negotiation', 'won', 'lost'];

        return view('partner.leads.index', compact('leads', 'stages'));
    }

    public function create()
    {
        return view('partner.leads.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sponsor_id' => 'nullable|exists:sponsors,id',
            'event_id' => 'nullable|exists:events,id',
            'source' => 'required|string|max:50',
            'stage' => 'required|string|max:30',
            'value' => 'nullable|numeric|min:0',
            'probability' => 'nullable|integer|min:0|max:100',
            'priority' => 'required|in:low,medium,high',
            'expected_close_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        $this->leadService->create(Auth::id(), $validated);

        return redirect()->route('partner.leads.index')->with('success', 'Lead created successfully.');
    }

    public function show(int $id)
    {
        $lead = PartnerLead::with(['sponsor', 'event', 'createdBy', 'assignedTo'])
            ->where('partner_id', Auth::id())
            ->findOrFail($id);

        return view('partner.leads.show', compact('lead'));
    }

    public function updateStage(Request $request, int $id)
    {
        $validated = $request->validate([
            'stage' => 'required|string|max:30',
            'lost_reason' => 'nullable|string|max:255',
        ]);

        $lead = PartnerLead::where('partner_id', Auth::id())->findOrFail($id);
        $this->leadService->updateStage($lead, $validated['stage'], $validated['lost_reason'] ?? null);

        return redirect()->route('partner.leads.index')->with('success', 'Lead stage updated.');
    }
}
