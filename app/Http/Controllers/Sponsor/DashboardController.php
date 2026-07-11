<?php

declare(strict_types=1);

namespace App\Http\Controllers\Sponsor;

use App\Http\Controllers\Controller;
use App\Models\Sponsor;
use App\Models\SponsorAnnouncement;
use App\Models\SponsorBudget;
use App\Models\SponsorCampaign;
use App\Models\SponsorInvoice;
use App\Models\SponsorProposal;
use App\Models\SponsorSavedEvent;
use App\Models\SponsorshipContract;
use App\Models\SponsorTask;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $userId = auth()->id();
        $sponsor = Sponsor::where('user_id', $userId)->first();
        $sponsorId = $sponsor?->id;

        $currentBudget = SponsorBudget::where('sponsor_id', $userId)
            ->where('fiscal_year', date('Y'))
            ->first();

        $stats = [
            'active_sponsorships' => SponsorProposal::where('sponsor_id', $userId)
                ->whereIn('status', ['active', 'contracted', 'payment_pending'])
                ->count() ?: auth()->user()->sponsorshipRequests()->accepted()->count(),
            'pending_requests' => SponsorProposal::where('sponsor_id', $userId)
                ->whereIn('status', ['submitted', 'viewed', 'shortlisted'])
                ->count() ?: auth()->user()->sponsorshipRequests()->pending()->count(),
            'negotiating' => SponsorProposal::where('sponsor_id', $userId)
                ->whereIn('status', ['negotiating', 'counter_offer'])
                ->count(),
            'total_invested' => SponsorProposal::where('sponsor_id', $userId)
                ->whereIn('status', ['agreed', 'contracted', 'payment_pending', 'active', 'completed'])
                ->sum('budget_offer') ?: auth()->user()->sponsorshipRequests()->accepted()->with('package')->get()->sum('package.price'),
            'saved_count' => SponsorSavedEvent::where('sponsor_id', $userId)->count(),
            'active_campaigns' => SponsorCampaign::where('sponsor_id', $userId)
                ->where('status', 'active')->count(),
            'avg_roi' => SponsorCampaign::where('sponsor_id', $userId)
                ->whereNotNull('roi')->avg('roi'),
            'active_contracts' => SponsorshipContract::whereHas('request', fn ($q) => $q->where('sponsor_id', $userId))
                ->where('status', 'active')->count(),
            'upcoming_payments' => $sponsorId ? (float) SponsorInvoice::where('sponsor_id', $sponsorId)
                ->whereNotIn('status', ['paid', 'cancelled'])
                ->where('due_date', '>=', now())
                ->sum(DB::raw('total - amount_paid')) : 0,
            'overdue_invoices' => $sponsorId ? SponsorInvoice::where('sponsor_id', $sponsorId)
                ->overdue()->count() : 0,
            'pending_tasks' => $sponsorId ? SponsorTask::where('sponsor_id', $sponsorId)
                ->whereIn('status', ['todo', 'in_progress'])->count() : 0,
        ];

        $budget = $currentBudget;

        $savedEvents = SponsorSavedEvent::where('sponsor_id', $userId)
            ->with('event')
            ->latest()
            ->take(5)
            ->get();

        $recentCampaigns = SponsorCampaign::where('sponsor_id', $userId)
            ->with('event')
            ->latest()
            ->take(5)
            ->get();

        $recentProposals = SponsorProposal::where('sponsor_id', $userId)
            ->with(['event', 'package'])
            ->latest()
            ->take(5)
            ->get();

        $recentRequests = auth()->user()->sponsorshipRequests()
            ->with(['event', 'package'])
            ->latest()
            ->take(5)
            ->get();

        $recentAnnouncements = $sponsorId
            ? SponsorAnnouncement::where('sponsor_id', $sponsorId)
                ->where('status', 'published')
                ->latest('published_at')
                ->take(3)
                ->get()
            : collect();

        return view('sponsor.dashboard', compact(
            'stats', 'budget', 'savedEvents', 'recentCampaigns',
            'recentProposals', 'recentRequests', 'recentAnnouncements'
        ));
    }
}
