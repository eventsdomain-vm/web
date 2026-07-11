<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PartnerMeeting;
use Illuminate\Http\Request;

class AdminPartnerMeetingController extends Controller
{
    public function index(Request $request)
    {
        $query = PartnerMeeting::with(['partner', 'sponsor', 'deal']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('search')) {
            $query->whereHas('partner', function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%");
            });
        }

        $meetings = $query->orderByDesc('start_time')->paginate(20);

        return view('admin.partner-meetings.index', compact('meetings'));
    }

    public function show(PartnerMeeting $meeting)
    {
        $meeting->load(['partner', 'sponsor', 'deal', 'lead', 'createdBy']);

        return view('admin.partner-meetings.show', compact('meeting'));
    }
}
