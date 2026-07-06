<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\SponsorshipPackage;
use App\Models\SponsorshipRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SponsorAcquisitionController extends Controller
{
    public function index()
    {
        $events = Event::where('organizer_id', Auth::id())
            ->where('status', 'published')
            ->withCount(['sponsorshipRequests', 'sponsorshipRequests as pending_requests_count' => function ($q) {
                $q->where('status', 'pending');
            }])
            ->get();

        $recentRequests = SponsorshipRequest::with(['sponsor', 'event', 'package'])
            ->whereIn('event_id', Event::where('organizer_id', Auth::id())->pluck('id'))
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

        return view('organizer.acquisition.index', compact('events', 'recentRequests'));
    }

    public function invite(Request $request, Event $event)
    {
        $package = SponsorshipPackage::where('event_id', $event->id)->findOrFail($request->package_id);

        $validated = $request->validate([
            'sponsor_id' => 'required|exists:sponsors,id',
            'message' => 'nullable|string|max:1000',
        ]);

        SponsorshipRequest::create([
            'event_id' => $event->id,
            'sponsor_id' => $validated['sponsor_id'],
            'package_id' => $package->id,
            'message' => $validated['message'] ?? null,
            'status' => 'pending',
        ]);

        return redirect()->route('organizer.acquisition.index')->with('success', 'Sponsor invited.');
    }
}
