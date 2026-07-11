<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PartnerCampaign;
use Illuminate\Http\Request;

class AdminPartnerCampaignController extends Controller
{
    public function index(Request $request)
    {
        $query = PartnerCampaign::with(['partner', 'sponsor', 'event']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->whereHas('partner', function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%");
            });
        }

        $campaigns = $query->latest()->paginate(20);

        return view('admin.partner-campaigns.index', compact('campaigns'));
    }

    public function show(PartnerCampaign $campaign)
    {
        $campaign->load(['partner', 'sponsor', 'event', 'deal']);

        return view('admin.partner-campaigns.show', compact('campaign'));
    }
}
