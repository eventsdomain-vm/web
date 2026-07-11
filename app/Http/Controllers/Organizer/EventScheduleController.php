<?php

declare(strict_types=1);

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventSchedule;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EventScheduleController extends Controller
{
    public function index(Event $event): View
    {
        abort_if($event->organizer_id !== auth()->id(), 403);

        $schedules = $event->schedule()->orderBy('start_time')->get();

        return view('organizer.events.schedules.index', compact('event', 'schedules'));
    }

    public function create(Event $event): View
    {
        abort_if($event->organizer_id !== auth()->id(), 403);

        return view('organizer.events.schedules.create', compact('event'));
    }

    public function store(Request $request, Event $event): RedirectResponse
    {
        abort_if($event->organizer_id !== auth()->id(), 403);

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

        return redirect()->route('organizer.events.schedules.index', $event)
            ->with('success', 'Schedule item added successfully!');
    }

    public function edit(Event $event, EventSchedule $schedule): View
    {
        abort_if($event->organizer_id !== auth()->id() || $schedule->event_id !== $event->id, 403);

        return view('organizer.events.schedules.edit', compact('event', 'schedule'));
    }

    public function update(Request $request, Event $event, EventSchedule $schedule): RedirectResponse
    {
        abort_if($event->organizer_id !== auth()->id() || $schedule->event_id !== $event->id, 403);

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

        return redirect()->route('organizer.events.schedules.index', $event)
            ->with('success', 'Schedule item updated successfully!');
    }

    public function destroy(Event $event, EventSchedule $schedule): RedirectResponse
    {
        abort_if($event->organizer_id !== auth()->id() || $schedule->event_id !== $event->id, 403);

        $schedule->delete();

        return redirect()->route('organizer.events.schedules.index', $event)
            ->with('success', 'Schedule item deleted successfully!');
    }
}
