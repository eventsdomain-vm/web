<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrganizerSponsorRelationship;
use Illuminate\Http\Request;

class AdminOrganizerSRMController extends Controller
{
    public function index(Request $request)
    {
        $query = OrganizerSponsorRelationship::with(['sponsor', 'user']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->whereHas('sponsor', function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%");
            });
        }

        $relationships = $query->orderByDesc('health_score')->paginate(20);

        return view('admin.organizers.srm', compact('relationships'));
    }

    public function show(OrganizerSponsorRelationship $relationship)
    {
        $relationship->load(['sponsor', 'user', 'event']);
        $contracts = \App\Models\SponsorshipContract::where('sponsor_id', $relationship->sponsor_id)->get();
        $renewals = \App\Models\OrganizerRenewal::where('sponsor_id', $relationship->sponsor_id)->get();

        return view('admin.organizers.srm-show', compact('relationship', 'contracts', 'renewals'));
    }
}
