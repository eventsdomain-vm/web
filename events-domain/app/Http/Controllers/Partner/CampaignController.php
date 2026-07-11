<?php

declare(strict_types=1);

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\PartnerCampaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CampaignController extends Controller
{
    public function index()
    {
        $campaigns = PartnerCampaign::with(['sponsor', 'event'])
            ->where('partner_id', Auth::id())
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('partner.campaigns.index', compact('campaigns'));
    }

    public function show(int $id)
    {
        $campaign = PartnerCampaign::with(['sponsor', 'event', 'deal'])
            ->where('partner_id', Auth::id())
            ->findOrFail($id);

        return view('partner.campaigns.show', compact('campaign'));
    }

    public function updateStatus(Request $request, int $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:planning,active,completed,paused',
        ]);

        $campaign = PartnerCampaign::where('partner_id', Auth::id())->findOrFail($id);
        $campaign->status = $validated['status'];
        $campaign->save();

        return redirect()->route('partner.campaigns.show', $id)->with('success', 'Campaign status updated.');
    }
}
