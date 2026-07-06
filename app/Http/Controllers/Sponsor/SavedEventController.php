<?php

declare(strict_types=1);

namespace App\Http\Controllers\Sponsor;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\SponsorSavedEvent;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SavedEventController extends Controller
{
    public function index(): View
    {
        $savedEvents = auth()->user()->sponsorSavedEvents()
            ->with('event.organizer', 'event.category')
            ->latest()
            ->paginate(12);

        return view('sponsor.saved.index', compact('savedEvents'));
    }

    public function store(Event $event): RedirectResponse
    {
        $user = auth()->user();

        $exists = SponsorSavedEvent::where('sponsor_id', $user->id)
            ->where('event_id', $event->id)
            ->exists();

        if (! $exists) {
            SponsorSavedEvent::create([
                'sponsor_id' => $user->id,
                'event_id' => $event->id,
            ]);
        }

        return redirect()->back()->with('success', 'Event saved to your watchlist.');
    }

    public function destroy(Event $event): RedirectResponse
    {
        auth()->user()->sponsorSavedEvents()
            ->where('event_id', $event->id)
            ->delete();

        return redirect()->back()->with('success', 'Event removed from your watchlist.');
    }

    public function toggle(Event $event): JsonResponse
    {
        $user = auth()->user();
        $saved = SponsorSavedEvent::where('sponsor_id', $user->id)
            ->where('event_id', $event->id)
            ->first();

        if ($saved) {
            $saved->delete();

            return response()->json(['saved' => false]);
        }

        SponsorSavedEvent::create([
            'sponsor_id' => $user->id,
            'event_id' => $event->id,
        ]);

        return response()->json(['saved' => true]);
    }
}
