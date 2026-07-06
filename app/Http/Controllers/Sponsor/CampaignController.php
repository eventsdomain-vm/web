<?php

declare(strict_types=1);

namespace App\Http\Controllers\Sponsor;

use App\Http\Controllers\Controller;
use App\Models\SponsorCampaign;
use App\Models\SponsorCampaignDeliverable;
use App\Services\SponsorCampaignService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CampaignController extends Controller
{
    public function __construct(
        protected SponsorCampaignService $campaignService,
    ) {}

    public function index(): View
    {
        $campaigns = SponsorCampaign::where('sponsor_id', auth()->id())
            ->with('event')
            ->latest()
            ->paginate(15);

        return view('sponsor.campaigns.index', compact('campaigns'));
    }

    public function show(SponsorCampaign $campaign): View
    {
        if ($campaign->sponsor_id !== auth()->id()) {
            abort(403);
        }

        $campaign->load(['event', 'deliverables', 'milestones', 'tasks']);

        $progress = $this->campaignService->getCampaignProgress($campaign);

        return view('sponsor.campaigns.show', compact('campaign', 'progress'));
    }

    public function update(Request $request, SponsorCampaign $campaign): RedirectResponse
    {
        if ($campaign->sponsor_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'status' => 'sometimes|in:draft,active,paused,completed,cancelled',
            'budget' => 'sometimes|numeric|min:0',
            'start_date' => 'sometimes|date',
            'end_date' => 'sometimes|date|after_or_equal:start_date',
        ]);

        $this->campaignService->updateCampaign($campaign, $validated);

        return redirect()->route('sponsor.campaigns.show', $campaign)
            ->with('success', 'Campaign updated.');
    }

    public function storeDeliverable(Request $request, SponsorCampaign $campaign): RedirectResponse
    {
        if ($campaign->sponsor_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|string|max:50',
            'description' => 'nullable|string',
        ]);

        $this->campaignService->addDeliverable($campaign, $validated);

        return redirect()->route('sponsor.campaigns.show', $campaign)
            ->with('success', 'Deliverable added.');
    }

    public function updateDeliverable(Request $request, SponsorCampaignDeliverable $deliverable): RedirectResponse
    {
        if ($deliverable->campaign->sponsor_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'status' => 'required|in:pending,in_progress,completed,cancelled',
            'notes' => 'nullable|string',
        ]);

        $this->campaignService->updateDeliverable($deliverable, $validated);

        return redirect()->back()->with('success', 'Deliverable updated.');
    }
}
