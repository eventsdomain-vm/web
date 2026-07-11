<?php

declare(strict_types=1);

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\SponsorProposal;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProposalController extends Controller
{
    public function accept(Event $event, SponsorProposal $proposal): RedirectResponse
    {
        $this->authorize('update', $event);

        abort_if($proposal->event_id !== $event->id, 404);

        if ($proposal->status !== 'submitted' && $proposal->status !== 'viewed' && $proposal->status !== 'shortlisted') {
            return redirect()->back()->with('error', 'This proposal cannot be accepted at this stage.');
        }

        $proposal->accept();

        // Notify sponsor
        $proposal->sponsor->notify(new \App\Notifications\ProposalAcceptedNotification($proposal));

        return redirect()->back()
            ->with('success', 'Proposal accepted successfully.');
    }

    public function reject(Event $event, SponsorProposal $proposal, Request $request): RedirectResponse
    {
        $this->authorize('update', $event);

        abort_if($proposal->event_id !== $event->id, 404);

        if ($proposal->status === 'agreed' || $proposal->status === 'contracted' || $proposal->status === 'completed') {
            return redirect()->back()->with('error', 'This proposal cannot be rejected.');
        }

        $validated = $request->validate([
            'rejection_note' => 'nullable|string|max:2000',
        ]);

        $proposal->update([
            'status' => 'rejected',
            'organizer_note' => $validated['rejection_note'] ?? null,
        ]);

        // Notify sponsor
        $proposal->sponsor->notify(new \App\Notifications\ProposalRejectedNotification($proposal));

        return redirect()->back()
            ->with('success', 'Proposal rejected.');
    }

    public function shortlist(Event $event, SponsorProposal $proposal): RedirectResponse
    {
        $this->authorize('update', $event);

        abort_if($proposal->event_id !== $event->id, 404);

        if (! in_array($proposal->status, ['submitted', 'viewed'])) {
            return redirect()->back()->with('error', 'This proposal cannot be shortlisted.');
        }

        $proposal->update(['status' => 'shortlisted']);

        return redirect()->back()
            ->with('success', 'Proposal shortlisted.');
    }

    public function startNegotiation(Event $event, SponsorProposal $proposal, Request $request): RedirectResponse
    {
        $this->authorize('update', $event);

        abort_if($proposal->event_id !== $event->id, 404);

        $validated = $request->validate([
            'organizer_note' => 'nullable|string|max:2000',
        ]);

        if (! in_array($proposal->status, ['submitted', 'viewed', 'shortlisted'])) {
            return redirect()->back()->with('error', 'Cannot start negotiation at this stage.');
        }

        $proposal->update([
            'status' => 'negotiating',
            'organizer_note' => $validated['organizer_note'] ?? null,
        ]);

        $proposal->sponsor->notify(new \App\Notifications\ProposalNegotiationStartedNotification($proposal));

        return redirect()->back()
            ->with('success', 'Negotiation started.');
    }

    public function sendCounterOffer(Event $event, SponsorProposal $proposal, Request $request): RedirectResponse
    {
        $this->authorize('update', $event);

        abort_if($proposal->event_id !== $event->id, 404);

        $validated = $request->validate([
            'counter_amount' => 'required|numeric|min:0',
            'counter_message' => 'nullable|string|max:2000',
        ]);

        if (! in_array($proposal->status, ['negotiating', 'counter_offer'])) {
            return redirect()->back()->with('error', 'Cannot send counter offer at this stage.');
        }

        $proposal->update([
            'status' => 'counter_offer',
            'counter_amount' => $validated['counter_amount'],
            'counter_message' => $validated['counter_message'] ?? null,
        ]);

        $proposal->sponsor->notify(new \App\Notifications\ProposalCounterOfferSentNotification($proposal));

        return redirect()->back()
            ->with('success', 'Counter offer sent to sponsor.');
    }
}
