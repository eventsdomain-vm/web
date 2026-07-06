<?php

declare(strict_types=1);

namespace App\Http\Controllers\Sponsor;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\SponsorProposal;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProposalController extends Controller
{
    public function index(): View
    {
        $proposals = auth()->user()->sponsorProposals()
            ->with('event', 'package')
            ->latest()
            ->paginate(15);

        return view('sponsor.proposals.index', compact('proposals'));
    }

    public function show(SponsorProposal $proposal): View
    {
        if ($proposal->sponsor_id !== auth()->id()) {
            abort(403);
        }

        $proposal->load('event.organizer', 'event.category', 'package.benefitRecords');

        return view('sponsor.proposals.show', compact('proposal'));
    }

    public function create(Event $event): View
    {
        $event->load('organizer', 'category', 'packages.benefitRecords');

        return view('sponsor.proposals.create', compact('event'));
    }

    public function store(Request $request, Event $event): RedirectResponse
    {
        $validated = $request->validate([
            'package_id' => 'required|exists:sponsor_packages,id',
            'message' => 'required|string|max:5000',
            'budget_offer' => 'nullable|numeric|min:0',
            'additional_benefits' => 'nullable|string|max:2000',
            'internal_note' => 'nullable|string|max:2000',
        ]);

        $proposal = SponsorProposal::create([
            'event_id' => $event->id,
            'sponsor_id' => auth()->id(),
            'package_id' => $validated['package_id'],
            'status' => 'draft',
            'message' => $validated['message'],
            'budget_offer' => $validated['budget_offer'] ?? null,
            'additional_benefits' => $validated['additional_benefits'] ?? null,
            'internal_note' => $validated['internal_note'] ?? null,
        ]);

        return redirect()->route('sponsor.proposals.show', $proposal)
            ->with('success', 'Proposal saved as draft. Submit it when ready.');
    }

    public function submit(SponsorProposal $proposal): RedirectResponse
    {
        if ($proposal->sponsor_id !== auth()->id()) {
            abort(403);
        }

        if ($proposal->status !== 'draft') {
            return redirect()->back()->with('error', 'Only draft proposals can be submitted.');
        }

        $proposal->update(['status' => 'submitted']);

        $proposal->sponsor->notify(new SponsorProposalNotification(
            eventTitle: $proposal->event->title,
            statusChanges: ['from' => 'draft', 'to' => 'submitted'],
            proposalId: $proposal->id,
        ));

        return redirect()->route('sponsor.proposals.show', $proposal)
            ->with('success', 'Proposal submitted to the organizer. You will be notified when they respond.');
    }

    public function withdraw(SponsorProposal $proposal): RedirectResponse
    {
        if ($proposal->sponsor_id !== auth()->id()) {
            abort(403);
        }

        if (! in_array($proposal->status, ['submitted', 'viewed', 'shortlisted', 'negotiating', 'counter_offer'])) {
            return redirect()->back()->with('error', 'This proposal cannot be withdrawn.');
        }

        $proposal->update(['status' => 'withdrawn']);

        $proposal->sponsor->notify(new SponsorProposalNotification(
            eventTitle: $proposal->event->title,
            statusChanges: ['from' => $proposal->status, 'to' => 'withdrawn'],
            proposalId: $proposal->id,
        ));

        return redirect()->route('sponsor.proposals.index')
            ->with('success', 'Proposal withdrawn.');
    }

    public function acceptCounter(SponsorProposal $proposal): RedirectResponse
    {
        if ($proposal->sponsor_id !== auth()->id()) {
            abort(403);
        }

        if ($proposal->status !== 'counter_offer') {
            return redirect()->back()->with('error', 'No counter offer to accept.');
        }

        $proposal->accept();

        $proposal->sponsor->notify(new SponsorProposalNotification(
            eventTitle: $proposal->event->title,
            statusChanges: ['from' => 'counter_offer', 'to' => 'agreed'],
            proposalId: $proposal->id,
        ));

        return redirect()->route('sponsor.proposals.show', $proposal)
            ->with('success', 'Counter offer accepted. Proceeding to contract.');
    }

    public function counterOffer(Request $request, SponsorProposal $proposal): RedirectResponse
    {
        if ($proposal->sponsor_id !== auth()->id()) {
            abort(403);
        }

        if ($proposal->status !== 'negotiating' && $proposal->status !== 'counter_offer') {
            return redirect()->back()->with('error', 'Cannot counter offer at this stage.');
        }

        $validated = $request->validate([
            'counter_amount' => 'required|numeric|min:0',
            'counter_message' => 'nullable|string|max:2000',
        ]);

        $oldStatus = $proposal->status;
        $proposal->update([
            'status' => 'counter_offer',
            'counter_amount' => $validated['counter_amount'],
            'counter_message' => $validated['counter_message'],
        ]);

        if ($oldStatus !== 'counter_offer' && $proposal->sponsor) {
            $proposal->sponsor->notify(new SponsorProposalNotification(
                eventTitle: $proposal->event->title,
                statusChanges: ['from' => $oldStatus, 'to' => 'counter_offer'],
                proposalId: $proposal->id,
            ));
        }

        return redirect()->route('sponsor.proposals.show', $proposal)
            ->with('success', 'Counter offer sent to organizer.');
    }
}
