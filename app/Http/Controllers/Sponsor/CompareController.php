<?php

declare(strict_types=1);

namespace App\Http\Controllers\Sponsor;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\SponsorComparison;
use App\Models\SponsorComparisonItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CompareController extends Controller
{
    public function index(): View
    {
        $comparisons = auth()->user()->sponsorComparisons()
            ->withCount('items')
            ->latest()
            ->get();

        return view('sponsor.compare.index', compact('comparisons'));
    }

    public function show(SponsorComparison $comparison): View
    {
        if ($comparison->sponsor_id !== auth()->id()) {
            abort(403);
        }

        $comparison->load('events.organizer', 'events.category', 'events.packages');

        return view('sponsor.compare.show', compact('comparison'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'event_ids' => 'required|array|min:2|max:5',
            'event_ids.*' => 'exists:events,id',
            'name' => 'nullable|string|max:100',
        ]);

        $comparison = SponsorComparison::create([
            'sponsor_id' => auth()->id(),
            'name' => $validated['name'] ?? 'Comparison '.now()->format('M d, Y'),
        ]);

        foreach ($validated['event_ids'] as $eventId) {
            SponsorComparisonItem::create([
                'comparison_id' => $comparison->id,
                'event_id' => $eventId,
            ]);
        }

        return redirect()->route('sponsor.compare.show', $comparison)
            ->with('success', 'Comparison created. You can now view events side-by-side.');
    }

    public function addEvent(Request $request, SponsorComparison $comparison): RedirectResponse
    {
        if ($comparison->sponsor_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'event_id' => 'required|exists:events,id|unique:sponsor_comparison_items,event_id,NULL,id,comparison_id,'.$comparison->id,
        ]);

        SponsorComparisonItem::create([
            'comparison_id' => $comparison->id,
            'event_id' => $validated['event_id'],
        ]);

        return redirect()->back()->with('success', 'Event added to comparison.');
    }

    public function removeEvent(SponsorComparison $comparison, Event $event): RedirectResponse
    {
        if ($comparison->sponsor_id !== auth()->id()) {
            abort(403);
        }

        SponsorComparisonItem::where('comparison_id', $comparison->id)
            ->where('event_id', $event->id)
            ->delete();

        return redirect()->back()->with('success', 'Event removed from comparison.');
    }

    public function destroy(SponsorComparison $comparison): RedirectResponse
    {
        if ($comparison->sponsor_id !== auth()->id()) {
            abort(403);
        }

        $comparison->delete();

        return redirect()->route('sponsor.compare.index')
            ->with('success', 'Comparison deleted.');
    }
}
