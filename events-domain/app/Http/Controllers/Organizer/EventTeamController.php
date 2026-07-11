<?php

declare(strict_types=1);

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventTeam;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EventTeamController extends Controller
{
    public function index(Event $event): View
    {
        abort_if($event->organizer_id !== auth()->id(), 403);

        $team = $event->team()->with('user')->get();

        return view('organizer.events.team.index', compact('event', 'team'));
    }

    public function create(Event $event): View
    {
        abort_if($event->organizer_id !== auth()->id(), 403);

        $users = User::where('id', '!=', auth()->id())->orderBy('name')->get();

        return view('organizer.events.team.create', compact('event', 'users'));
    }

    public function store(Request $request, Event $event): RedirectResponse
    {
        abort_if($event->organizer_id !== auth()->id(), 403);

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'required|string|max:100',
        ]);

        $exists = EventTeam::where('event_id', $event->id)
            ->where('user_id', $validated['user_id'])
            ->exists();

        if ($exists) {
            return back()->with('error', 'This user is already a member of your event team.');
        }

        $validated['event_id'] = $event->id;
        EventTeam::create($validated);

        return redirect()->route('organizer.events.team.index', $event)
            ->with('success', 'Team member added successfully!');
    }

    public function destroy(Event $event, EventTeam $team): RedirectResponse
    {
        abort_if($event->organizer_id !== auth()->id() || $team->event_id !== $event->id, 403);

        $team->delete();

        return redirect()->route('organizer.events.team.index', $event)
            ->with('success', 'Team member removed successfully!');
    }
}
