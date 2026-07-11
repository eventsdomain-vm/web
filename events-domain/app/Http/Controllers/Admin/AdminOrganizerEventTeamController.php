<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventTeam;
use App\Models\User;
use Illuminate\Http\Request;

class AdminOrganizerEventTeamController extends Controller
{
    public function index(Event $event)
    {
        $team = $event->team()->with('user')->get();

        return view('admin.organizers.event-team', compact('event', 'team'));
    }

    public function store(Request $request, Event $event)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'required|string|max:100',
        ]);

        $exists = EventTeam::where('event_id', $event->id)
            ->where('user_id', $validated['user_id'])
            ->exists();

        if ($exists) {
            return back()->with('error', 'User is already a team member.');
        }

        $validated['event_id'] = $event->id;
        EventTeam::create($validated);

        return redirect()->route('admin.events.team', $event)
            ->with('success', 'Team member added.');
    }

    public function destroy(Event $event, EventTeam $team)
    {
        $team->delete();

        return redirect()->route('admin.events.team', $event)
            ->with('success', 'Team member removed.');
    }
}
