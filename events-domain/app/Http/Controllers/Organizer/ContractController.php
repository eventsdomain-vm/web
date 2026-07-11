<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\SponsorshipContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContractController extends Controller
{
    public function index()
    {
        $contracts = SponsorshipContract::with(['sponsor', 'event'])
            ->whereIn('event_id', Event::where('organizer_id', Auth::id())->pluck('id'))
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('organizer.contracts.index', compact('contracts'));
    }

    public function show(int $id)
    {
        $contract = SponsorshipContract::with(['sponsor', 'event'])
            ->whereIn('event_id', Event::where('organizer_id', Auth::id())->pluck('id'))
            ->findOrFail($id);

        return view('organizer.contracts.show', compact('contract'));
    }

    public function updateStatus(Request $request, int $id)
    {
        $contract = SponsorshipContract::whereIn('event_id', Event::where('organizer_id', Auth::id())->pluck('id'))
            ->findOrFail($id);

        $contract->status = $request->status;
        if ($request->status === 'signed') {
            $contract->signed_at = now();
        }
        $contract->save();

        return back()->with('success', 'Contract status updated.');
    }
}
