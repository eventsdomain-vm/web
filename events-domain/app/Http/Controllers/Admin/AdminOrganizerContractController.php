<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\SponsorshipContract;
use Illuminate\Http\Request;

class AdminOrganizerContractController extends Controller
{
    public function index(Request $request)
    {
        $query = SponsorshipContract::with(['sponsor', 'event', 'event.organizer']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->whereHas('event', function ($q) use ($request) {
                $q->where('title', 'like', "%{$request->search}%");
            });
        }

        $contracts = $query->latest()->paginate(20);

        return view('admin.organizers.contracts', compact('contracts'));
    }

    public function show(SponsorshipContract $contract)
    {
        $contract->load(['sponsor', 'event', 'event.organizer', 'request']);

        return view('admin.organizers.contract-show', compact('contract'));
    }

    public function updateStatus(Request $request, SponsorshipContract $contract)
    {
        $validated = $request->validate([
            'status' => 'required|in:active,completed,terminated,signed',
        ]);

        $contract->status = $validated['status'];
        if ($validated['status'] === 'signed') {
            $contract->signed_at = now();
        }
        $contract->save();

        return back()->with('success', 'Contract status updated.');
    }
}
