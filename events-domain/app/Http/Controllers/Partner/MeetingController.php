<?php

declare(strict_types=1);

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\PartnerActivityLog;
use App\Models\PartnerMeeting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MeetingController extends Controller
{
    public function index(Request $request)
    {
        $partnerId = Auth::id();
        $query = PartnerMeeting::with(['sponsor', 'deal'])
            ->where('partner_id', $partnerId);

        if ($request->status) {
            $query->where('status', $request->status);
        }
        if ($request->type) {
            $query->where('type', $request->type);
        }

        $meetings = $query->orderByDesc('start_time')->paginate(20);

        return view('partner.meetings.index', compact('meetings'));
    }

    public function create()
    {
        return view('partner.meetings.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sponsor_id' => 'nullable|exists:sponsors,id',
            'deal_id' => 'nullable|exists:partner_deals,id',
            'lead_id' => 'nullable|exists:partner_leads,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:online,phone,in-person',
            'location' => 'nullable|string|max:255',
            'meeting_link' => 'nullable|url|max:500',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'timezone' => 'nullable|string|max:50',
            'notes' => 'nullable|string',
        ]);

        $validated['partner_id'] = Auth::id();
        $validated['created_by'] = Auth::id();
        $validated['timezone'] ??= 'UTC';

        $meeting = PartnerMeeting::create($validated);

        PartnerActivityLog::create([
            'partner_id' => Auth::id(),
            'causer_id' => Auth::id(),
            'subject_type' => PartnerMeeting::class,
            'subject_id' => $meeting->id,
            'event' => 'created',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return redirect()->route('partner.meetings.index')->with('success', 'Meeting scheduled.');
    }

    public function show(int $id)
    {
        $meeting = PartnerMeeting::with(['sponsor', 'deal', 'lead', 'createdBy'])
            ->where('partner_id', Auth::id())
            ->findOrFail($id);

        return view('partner.meetings.show', compact('meeting'));
    }

    public function updateStatus(Request $request, int $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:scheduled,confirmed,completed,cancelled',
            'minutes' => 'nullable|string',
        ]);

        $meeting = PartnerMeeting::where('partner_id', Auth::id())->findOrFail($id);
        $meeting->status = $validated['status'];
        if (! empty($validated['minutes'])) {
            $meeting->minutes = $validated['minutes'];
        }
        $meeting->save();

        return redirect()->route('partner.meetings.show', $id)->with('success', 'Meeting updated.');
    }
}
