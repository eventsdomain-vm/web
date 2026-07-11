<?php

declare(strict_types=1);

namespace App\Services\Partner;

use App\Models\PartnerAssignment;
use App\Models\PartnerCampaign;
use App\Models\PartnerCommission;
use App\Models\PartnerDeal;
use App\Models\PartnerLead;
use App\Models\PartnerMeeting;
use App\Models\PartnerTask;
use Illuminate\Support\Facades\DB;

class PartnerDashboardService
{
    public function kpis(int $partnerId): array
    {
        $assignments = PartnerAssignment::where('partner_id', $partnerId)
            ->where('status', 'active')->count();

        $activeLeads = PartnerLead::where('partner_id', $partnerId)
            ->whereNotIn('stage', ['won', 'lost'])->count();

        $pipelineValue = PartnerDeal::where('partner_id', $partnerId)
            ->whereNotIn('stage', ['completed', 'lost'])->sum('deal_value');

        $wonDeals = PartnerDeal::where('partner_id', $partnerId)
            ->where('stage', 'completed')->count();

        $runningCampaigns = PartnerCampaign::where('partner_id', $partnerId)
            ->where('status', 'active')->count();

        $commissionEarned = PartnerCommission::where('partner_id', $partnerId)
            ->where('status', 'paid')->sum('amount');

        $pendingCommission = PartnerCommission::where('partner_id', $partnerId)
            ->whereIn('status', ['pending', 'approved', 'processing'])->sum('amount');

        $upcomingMeetings = PartnerMeeting::where('partner_id', $partnerId)
            ->where('start_time', '>', now())
            ->where('status', '!=', 'cancelled')->count();

        return compact(
            'assignments', 'activeLeads', 'pipelineValue', 'wonDeals',
            'runningCampaigns', 'commissionEarned', 'pendingCommission', 'upcomingMeetings',
        );
    }

    public function recentActivities(int $partnerId, int $limit = 10): array
    {
        return DB::table('partner_activity_logs')
            ->where('partner_id', $partnerId)
            ->orderByDesc('created_at')
            ->limit($limit)
            ->get()
            ->toArray();
    }

    public function tasks(int $partnerId, int $limit = 5)
    {
        return PartnerTask::where('partner_id', $partnerId)
            ->where('status', '!=', 'completed')
            ->orderBy('due_date')
            ->limit($limit)
            ->get();
    }

    public function revenueTrend(int $partnerId, int $months = 6): array
    {
        return PartnerCommission::where('partner_id', $partnerId)
            ->where('status', 'paid')
            ->where('paid_at', '>=', now()->subMonths($months))
            ->select(DB::raw("DATE_FORMAT(paid_at, '%Y-%m') as month"), DB::raw('SUM(amount) as total'))
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->toArray();
    }

    public function pipelineFunnel(int $partnerId): array
    {
        $stages = ['qualification', 'proposal', 'negotiation', 'contract', 'payment', 'active', 'completed'];
        $funnel = [];
        foreach ($stages as $stage) {
            $funnel[$stage] = PartnerDeal::where('partner_id', $partnerId)
                ->where('stage', $stage)->count();
        }

        return $funnel;
    }
}
