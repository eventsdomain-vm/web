<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\SponsorshipRequest;
use App\Models\User;

class AdminReportController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'total_organizers' => User::role('organizer')->count(),
            'total_sponsors' => User::role('sponsor')->count(),
            'total_partners' => User::role('partner')->count(),
            'total_events' => Event::count(),
            'published_events' => Event::published()->count(),
            'pending_events' => Event::pending()->count(),
            'total_sponsorships' => SponsorshipRequest::count(),
            'accepted_sponsorships' => SponsorshipRequest::where('status', 'accepted')->count(),
        ];

        $recentEvents = Event::with('organizer')->latest()->take(10)->get();
        $recentUsers = User::with('roles')->latest()->take(10)->get();

        return view('admin.reports', compact('stats', 'recentEvents', 'recentUsers'));
    }

    public function show(string $type)
    {
        return match ($type) {
            'users' => $this->userReport(),
            'events' => $this->eventReport(),
            'sponsorships' => $this->sponsorshipReport(),
            default => redirect()->route('admin.reports')->with('error', 'Invalid report type.'),
        };
    }

    private function userReport()
    {
        $users = User::with('roles')->latest()->paginate(20);
        $stats = [
            'total' => User::count(),
            'organizers' => User::role('organizer')->count(),
            'sponsors' => User::role('sponsor')->count(),
            'partners' => User::role('partner')->count(),
            'verified' => User::where('is_verified', true)->count(),
        ];

        return view('admin.reports.users', compact('users', 'stats'));
    }

    private function eventReport()
    {
        $events = Event::with('organizer', 'category')->latest()->paginate(20);
        $stats = [
            'total' => Event::count(),
            'published' => Event::published()->count(),
            'pending' => Event::pending()->count(),
            'draft' => Event::where('status', 'draft')->count(),
            'rejected' => Event::where('status', 'rejected')->count(),
        ];

        return view('admin.reports.events', compact('events', 'stats'));
    }

    private function sponsorshipReport()
    {
        $sponsorships = SponsorshipRequest::with(['event', 'sponsor', 'package'])->latest()->paginate(20);
        $stats = [
            'total' => SponsorshipRequest::count(),
            'pending' => SponsorshipRequest::where('status', 'pending')->count(),
            'accepted' => SponsorshipRequest::where('status', 'accepted')->count(),
            'rejected' => SponsorshipRequest::where('status', 'rejected')->count(),
        ];

        return view('admin.reports.sponsorships', compact('sponsorships', 'stats'));
    }
}
