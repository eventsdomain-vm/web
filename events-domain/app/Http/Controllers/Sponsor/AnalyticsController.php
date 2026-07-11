<?php

declare(strict_types=1);

namespace App\Http\Controllers\Sponsor;

use App\Http\Controllers\Controller;
use App\Models\Sponsor;
use App\Models\SponsorBudget;
use App\Models\SponsorCampaign;
use App\Models\SponsorCampaignDeliverable;
use App\Models\SponsorInvoice;
use App\Models\SponsorProposal;
use App\Models\SponsorshipContract;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AnalyticsController extends Controller
{
    public function index(): View
    {
        $userId = auth()->id();
        $sponsor = Sponsor::where('user_id', $userId)->first();
        $sponsorId = $sponsor?->id;

        $totalInvested = SponsorProposal::where('sponsor_id', $userId)
            ->whereIn('status', ['agreed', 'contracted', 'payment_pending', 'active', 'completed'])
            ->sum('budget_offer');

        $campaigns = SponsorCampaign::where('sponsor_id', $userId)->get();
        $activeCampaigns = $campaigns->where('status', 'active');
        $completedCampaigns = $campaigns->where('status', 'completed');

        $avgRoi = $campaigns->whereNotNull('roi')->avg('roi');

        $contracts = SponsorshipContract::whereHas('request', fn ($q) => $q->where('sponsor_id', $userId))
            ->where('status', 'active')->get();

        $invoices = $sponsorId
            ? SponsorInvoice::where('sponsor_id', $sponsorId)->get()
            : collect();

        $budgets = SponsorBudget::where('sponsor_id', $userId)->get();

        $monthlySpend = $sponsorId
            ? SponsorInvoice::where('sponsor_id', $sponsorId)
                ->where('status', 'paid')
                ->select(DB::raw("SUM(total) as total, DATE_FORMAT(paid_at, '%Y-%m') as month"))
                ->whereNotNull('paid_at')
                ->groupBy('month')
                ->orderBy('month')
                ->pluck('total', 'month')
            : collect();

        $deliverableCompletion = SponsorCampaignDeliverable::whereIn('campaign_id', $campaigns->pluck('id'))
            ->select(DB::raw("COUNT(*) as total, SUM(CASE WHEN status = 'completed' THEN 1 ELSE 0 END) as completed"))
            ->first();

        $topCampaigns = SponsorCampaign::where('sponsor_id', $userId)
            ->whereNotNull('roi')
            ->orderByDesc('roi')
            ->take(5)
            ->get();

        $kpiSummary = [
            'total_invested' => $totalInvested,
            'total_campaigns' => $campaigns->count(),
            'active_campaigns' => $activeCampaigns->count(),
            'completed_campaigns' => $completedCampaigns->count(),
            'avg_roi' => $avgRoi,
            'active_contracts' => $contracts->count(),
            'total_invoices' => $invoices->count(),
            'paid_invoices' => $invoices->where('status', 'paid')->count(),
            'total_budgeted' => $budgets->sum('total_budget'),
            'total_spent' => $budgets->sum('spent'),
            'deliverable_total' => $deliverableCompletion?->total ?? 0,
            'deliverable_completed' => $deliverableCompletion?->completed ?? 0,
            'monthly_spend' => $monthlySpend,
            'top_campaigns' => $topCampaigns,
            'campaigns' => $campaigns,
            'budgets' => $budgets,
            'invoices' => $invoices,
        ];

        return view('sponsor.analytics.index', compact('kpiSummary'));
    }
}
