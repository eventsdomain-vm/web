<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\OrganizerPostEventReport;
use App\Models\OrganizerSponsorRelationship;
use App\Models\SponsorshipContract;
use App\Models\SponsorshipRequest;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $events = Event::where('organizer_id', $userId);
        $totalEvents = (clone $events)->count();
        $publishedEvents = (clone $events)->where('status', 'approved')->count();
        $draftEvents = (clone $events)->where('status', 'draft')->count();

        $contracts = SponsorshipContract::whereIn('event_id', Event::where('organizer_id', $userId)->pluck('id'));
        $totalContractValue = (clone $contracts)->where('status', 'active')->sum('amount');
        $activeContracts = (clone $contracts)->where('status', 'active')->count();

        $requests = SponsorshipRequest::whereIn('event_id', Event::where('organizer_id', $userId)->pluck('id'));
        $pendingRequests = (clone $requests)->where('status', 'pending')->count();
        $acceptedRequests = (clone $requests)->where('status', 'accepted')->count();

        $postEventReports = OrganizerPostEventReport::where('user_id', $userId);
        $avgSatisfaction = (clone $postEventReports)->avg('sponsor_satisfaction');
        $avgROI = (clone $postEventReports)->avg('roi_percentage');
        $totalRevenue = (clone $postEventReports)->sum('revenue_generated');

        $sponsorRelationships = OrganizerSponsorRelationship::where('user_id', $userId);
        $activeSponsors = (clone $sponsorRelationships)->where('status', 'active')->count();
        $avgHealthScore = (clone $sponsorRelationships)->avg('health_score');

        return view('organizer.reports.index', compact(
            'totalEvents', 'publishedEvents', 'draftEvents',
            'totalContractValue', 'activeContracts',
            'pendingRequests', 'acceptedRequests',
            'avgSatisfaction', 'avgROI', 'totalRevenue',
            'activeSponsors', 'avgHealthScore',
        ));
    }
}
