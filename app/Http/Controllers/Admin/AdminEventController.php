<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;

class AdminEventController extends Controller
{
    use LogsActivity;

    public function index(Request $request)
    {
        $query = Event::with('organizer', 'category');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', "%{$request->search}%")
                    ->orWhere('city', 'like', "%{$request->search}%");
            });
        }

        $events = $query->latest()->paginate(20);

        return view('admin.events', compact('events'));
    }

    public function pending()
    {
        $events = Event::pending()
            ->with('organizer', 'category')
            ->latest()
            ->paginate(20);

        return view('admin.events', compact('events'));
    }

    public function show(Event $event)
    {
        $event->load(['organizer', 'category', 'packages.benefitRecords', 'gallery', 'schedule']);

        return view('admin.events-show', compact('event'));
    }

    public function approve(Event $event)
    {
        $event->update([
            'status' => 'approved',
            'approval_status' => 'approved',
            'is_published' => true,
            'published_at' => now(),
        ]);

        $this->logActivity(
            'event_approved',
            "Event '{$event->title}' approved and published",
            $event,
            ['previous_status' => $event->getOriginal('status'), 'new_status' => 'approved']
        );

        return redirect()->route('admin.events')
            ->with('success', 'Event approved and published successfully!');
    }

    public function reject(Request $request, Event $event)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        $event->update([
            'status' => 'rejected',
            'approval_status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
        ]);

        $this->logActivity(
            'event_rejected',
            "Event '{$event->title}' rejected",
            $event,
            ['previous_status' => 'pending', 'new_status' => 'rejected', 'reason' => $request->rejection_reason]
        );

        return redirect()->route('admin.events')
            ->with('success', 'Event rejected.');
    }
}
