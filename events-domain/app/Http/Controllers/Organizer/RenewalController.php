<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\OrganizerRenewal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RenewalController extends Controller
{
    public function index()
    {
        $renewals = OrganizerRenewal::with(['sponsor', 'contract'])
            ->where('user_id', Auth::id())
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('organizer.renewals.index', compact('renewals'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sponsor_id' => 'required|exists:sponsors,id',
            'contract_id' => 'nullable|exists:sponsorship_contracts,id',
            'status' => 'required|string|max:30',
            'proposed_value' => 'nullable|numeric|min:0',
            'probability' => 'nullable|integer|min:0|max:100',
            'expected_close_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        $validated['user_id'] = Auth::id();
        OrganizerRenewal::create($validated);

        return redirect()->route('organizer.renewals.index')->with('success', 'Renewal created.');
    }

    public function updateStage(Request $request, int $id)
    {
        $renewal = OrganizerRenewal::where('user_id', Auth::id())->findOrFail($id);
        $renewal->status = $request->status;
        if ($request->status === 'renewed') {
            $renewal->renewed_at = now();
        }
        $renewal->save();

        return back()->with('success', 'Renewal updated.');
    }
}
