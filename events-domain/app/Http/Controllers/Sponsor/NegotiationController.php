<?php

declare(strict_types=1);

namespace App\Http\Controllers\Sponsor;

use App\Http\Controllers\Controller;
use App\Models\SponsorNegotiation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NegotiationController extends Controller
{
    public function index(): View
    {
        $userId = auth()->id();

        $negotiations = SponsorNegotiation::whereHas('request', fn ($q) => $q->where('sponsor_id', $userId))
            ->with(['request.event', 'initiator', 'rounds'])
            ->latest()
            ->get();

        $openCount = $negotiations->where('status', 'open')->count();

        return view('sponsor.negotiations.index', compact('negotiations', 'openCount'));
    }

    public function show(SponsorNegotiation $negotiation): View
    {
        $userId = auth()->id();

        if ($negotiation->request->sponsor_id !== $userId) {
            abort(403);
        }

        $negotiation->load(['request.event', 'initiator', 'rounds.user']);

        return view('sponsor.negotiations.show', compact('negotiation'));
    }

    public function storeRound(Request $request, SponsorNegotiation $negotiation): RedirectResponse
    {
        $userId = auth()->id();

        if ($negotiation->request->sponsor_id !== $userId) {
            abort(403);
        }

        $validated = $request->validate([
            'message' => 'required|string',
            'offer' => 'nullable|numeric|min:0',
            'terms' => 'nullable|json',
        ]);

        $negotiation->rounds()->create([
            'user_id' => $userId,
            'message' => $validated['message'],
            'offer' => $validated['offer'],
            'terms' => $validated['terms'] ? json_decode($validated['terms'], true) : null,
        ]);

        $negotiation->update(['current_offer' => $validated['offer'] ?? $negotiation->current_offer]);

        return redirect()->route('sponsor.negotiations.show', $negotiation)
            ->with('success', 'Round added to negotiation.');
    }

    public function accept(SponsorNegotiation $negotiation): RedirectResponse
    {
        $userId = auth()->id();

        if ($negotiation->request->sponsor_id !== $userId) {
            abort(403);
        }

        $negotiation->accept();

        return redirect()->route('sponsor.negotiations.show', $negotiation)
            ->with('success', 'Negotiation accepted. Proceeding to contract.');
    }

    public function decline(SponsorNegotiation $negotiation): RedirectResponse
    {
        $userId = auth()->id();

        if ($negotiation->request->sponsor_id !== $userId) {
            abort(403);
        }

        $negotiation->decline();

        return redirect()->route('sponsor.negotiations.show', $negotiation)
            ->with('info', 'Negotiation declined.');
    }
}
