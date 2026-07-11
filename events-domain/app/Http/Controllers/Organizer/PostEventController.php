<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\OrganizerPostEventReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostEventController extends Controller
{
    public function index()
    {
        $reports = OrganizerPostEventReport::with('event')
            ->where('user_id', Auth::id())
            ->orderByDesc('created_at')
            ->paginate(20);

        $events = Event::where('organizer_id', Auth::id())
            ->where('status', 'approved')
            ->where('end_date', '<', now())
            ->orderByDesc('end_date')
            ->get();

        return view('organizer.post-event.index', compact('reports', 'events'));
    }

    public function create(Request $request)
    {
        $event = Event::where('organizer_id', Auth::id())->findOrFail($request->event_id);

        return view('organizer.post-event.create', compact('event'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'event_id' => 'required|exists:events,id',
            'total_attendance' => 'nullable|integer|min:0',
            'sponsor_booth_visits' => 'nullable|integer|min:0',
            'lead_generated' => 'nullable|integer|min:0',
            'sponsor_satisfaction' => 'nullable|numeric|min:0|max:5',
            'roi_percentage' => 'nullable|numeric|min:-100|max:1000',
            'revenue_generated' => 'nullable|numeric|min:0',
            'expenses_incurred' => 'nullable|numeric|min:0',
            'deliverable_fulfillment' => 'nullable|array',
            'deliverable_fulfillment.*' => 'string|max:500',
            'media_coverage' => 'nullable|array',
            'media_coverage.*' => 'string|max:500',
            'feedback_data' => 'nullable|array',
            'feedback_data.*' => 'string|max:500',
            'lessons_learned' => 'nullable|string',
            'improvement_notes' => 'nullable|string',
            'status' => 'required|in:draft,submitted',
        ]);

        $validated['user_id'] = Auth::id();
        if ($validated['status'] === 'submitted') {
            $validated['submitted_at'] = now();
        }

        OrganizerPostEventReport::updateOrCreate(
            ['user_id' => Auth::id(), 'event_id' => $validated['event_id']],
            $validated,
        );

        return redirect()->route('organizer.post-event.index')->with('success', 'Post-event report saved.');
    }

    public function show(int $id)
    {
        $report = OrganizerPostEventReport::with('event')
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('organizer.post-event.show', compact('report'));
    }
}
