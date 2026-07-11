<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrganizerPostEventReport;
use Illuminate\Http\Request;

class AdminOrganizerPostEventController extends Controller
{
    public function index(Request $request)
    {
        $query = OrganizerPostEventReport::with(['event', 'event.organizer']);

        if ($request->filled('search')) {
            $query->whereHas('event', function ($q) use ($request) {
                $q->where('title', 'like', "%{$request->search}%");
            });
        }

        $reports = $query->orderByDesc('created_at')->paginate(20);

        return view('admin.organizers.post-events', compact('reports'));
    }

    public function show(OrganizerPostEventReport $report)
    {
        $report->load(['event', 'event.organizer']);

        return view('admin.organizers.post-event-show', compact('report'));
    }
}
