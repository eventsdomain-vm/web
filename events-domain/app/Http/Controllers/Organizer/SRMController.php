<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\OrganizerRenewal;
use App\Models\OrganizerSponsorRelationship;
use App\Models\SponsorshipContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SRMController extends Controller
{
    public function index()
    {
        $relationships = OrganizerSponsorRelationship::with('sponsor')
            ->where('user_id', Auth::id())
            ->orderByDesc('health_score')
            ->paginate(20);

        return view('organizer.srm.index', compact('relationships'));
    }

    public function show(int $id)
    {
        $relationship = OrganizerSponsorRelationship::with(['sponsor', 'event'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        $contracts = SponsorshipContract::where('sponsor_id', $relationship->sponsor_id)->get();
        $renewals = OrganizerRenewal::where('sponsor_id', $relationship->sponsor_id)->get();

        return view('organizer.srm.show', compact('relationship', 'contracts', 'renewals'));
    }

    public function updateHealth(Request $request, int $id)
    {
        $relationship = OrganizerSponsorRelationship::where('user_id', Auth::id())->findOrFail($id);
        $relationship->health_score = $request->integer('health_score');
        $relationship->notes = $request->notes;
        $relationship->save();

        return back()->with('success', 'Relationship updated.');
    }
}
