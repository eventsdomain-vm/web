<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventSchedule;
use Illuminate\Http\Request;

class AdminOrganizerEventScheduleController extends Controller
{
    public function index(Event $event)
    {
        $schedules = $event->schedule()->orderBy('start_time')->get();

        return view('admin.organizers.event-schedules', compact('event', 'schedules'));
    }

    public function store(Request $request, Event $event)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'speaker' => 'nullable|string|max:255',
            'venue' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $validated['event_id'] = $event->id;
        EventSchedule::create($validated);

        return redirect()->route('admin.events.schedules', $event)
            ->with('success', 'Schedule item added.');
    }

    public function update(Request $request, Event $event, EventSchedule $schedule)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'speaker' => 'nullable|string|max:255',
            'venue' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $schedule->update($validated);

        return redirect()->route('admin.events.schedules', $event)
            ->with('success', 'Schedule item updated.');
    }

    public function destroy(Event $event, EventSchedule $schedule)
    {
        $schedule->delete();

        return redirect()->route('admin.events.schedules', $event)
            ->with('success', 'Schedule item deleted.');
    }
}
