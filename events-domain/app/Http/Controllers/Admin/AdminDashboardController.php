<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\OrganizerPostEventReport;
use App\Models\OrganizerRenewal;
use App\Models\OrganizerSponsorRelationship;
use App\Models\PartnerBid;
use App\Models\PartnerCommission;
use App\Models\PartnerDeal;
use App\Models\PartnerLead;
use App\Models\PartnerService;
use App\Models\SponsorshipContract;
use App\Models\SponsorshipRequest;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'total_organizers' => User::role('organizer')->count(),
            'total_sponsors' => User::role('sponsor')->count(),
            'total_partners' => User::role('partner')->count(),
            'total_events' => Event::count(),
            'pending_events' => Event::pending()->count(),
            'published_events' => Event::published()->count(),
            'total_sponsorship_requests' => SponsorshipRequest::count(),
            'total_partner_services' => PartnerService::count(),
            'total_partner_bids' => PartnerBid::count(),
            'total_contracts' => SponsorshipContract::count(),
            'active_contracts' => SponsorshipContract::where('status', 'active')->count(),
            'total_renewals' => OrganizerRenewal::count(),
            'active_renewals' => OrganizerRenewal::where('status', 'renewed')->count(),
            'total_post_event_reports' => OrganizerPostEventReport::count(),
            'avg_roi' => OrganizerPostEventReport::avg('roi_percentage'),
            'avg_satisfaction' => OrganizerPostEventReport::avg('sponsor_satisfaction'),
            'total_srm_relationships' => OrganizerSponsorRelationship::count(),
            'total_leads' => PartnerLead::count(),
            'won_leads' => PartnerLead::where('stage', 'won')->count(),
            'total_deals' => PartnerDeal::count(),
            'total_commission_paid' => PartnerCommission::where('status', 'paid')->sum('amount'),
            'total_commission_pending' => PartnerCommission::where('status', 'pending')->sum('amount'),
        ];

        $recentUsers = User::with('roles')->latest()->take(10)->get();
        $pendingEvents = Event::pending()->with('organizer')->latest()->take(10)->get();
        $recentContracts = SponsorshipContract::with(['event', 'sponsor'])->latest()->take(5)->get();
        $recentLeads = PartnerLead::with(['partner', 'sponsor'])->latest()->take(5)->get();
        $recentReports = OrganizerPostEventReport::with('event')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'stats', 'recentUsers', 'pendingEvents',
            'recentContracts', 'recentLeads', 'recentReports',
        ));
    }
}
