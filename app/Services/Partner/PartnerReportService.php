<?php

declare(strict_types=1);

namespace App\Services\Partner;

use App\Models\PartnerCampaign;
use App\Models\PartnerCommission;
use App\Models\PartnerDeal;
use App\Models\PartnerLead;
use Illuminate\Support\Facades\DB;

class PartnerReportService
{
    public function revenue(int $partnerId): array
    {
        $monthly = PartnerCommission::where('partner_id', $partnerId)
            ->where('status', 'paid')
            ->select(
                DB::raw("DATE_FORMAT(paid_at, '%Y-%m') as month"),
                DB::raw('SUM(amount) as total'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->toArray();

        $total = array_sum(array_column($monthly, 'total'));

        return compact('monthly', 'total');
    }

    public function leadFunnel(int $partnerId): array
    {
        $stages = ['new', 'contacted', 'qualified', 'proposal', 'negotiation', 'won', 'lost'];
        $data = [];
        foreach ($stages as $stage) {
            $data[$stage] = PartnerLead::where('partner_id', $partnerId)
                ->where('stage', $stage)->count();
        }

        return $data;
    }

    public function conversion(int $partnerId): array
    {
        $totalLeads = PartnerLead::where('partner_id', $partnerId)->count();
        $wonLeads = PartnerLead::where('partner_id', $partnerId)
            ->where('stage', 'won')->count();
        $lostLeads = PartnerLead::where('partner_id', $partnerId)
            ->where('stage', 'lost')->count();

        $rate = $totalLeads > 0 ? round(($wonLeads / $totalLeads) * 100, 1) : 0;

        return compact('totalLeads', 'wonLeads', 'lostLeads', 'rate');
    }

    public function commission(int $partnerId): array
    {
        $byStatus = PartnerCommission::where('partner_id', $partnerId)
            ->select('status', DB::raw('SUM(amount) as total'), DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->get()
            ->keyBy('status')
            ->toArray();

        $total = PartnerCommission::where('partner_id', $partnerId)->sum('amount');

        return compact('byStatus', 'total');
    }

    public function campaignPerformance(int $partnerId): array
    {
        return PartnerCampaign::where('partner_id', $partnerId)
            ->select('name', 'status', 'budget', 'attendance', 'engagement')
            ->get()
            ->toArray();
    }

    public function partnerPerformance(int $partnerId): array
    {
        $totalDeals = PartnerDeal::where('partner_id', $partnerId)->count();
        $wonDeals = PartnerDeal::where('partner_id', $partnerId)
            ->where('stage', 'completed')->count();
        $totalValue = PartnerDeal::where('partner_id', $partnerId)->sum('deal_value');

        $winRate = $totalDeals > 0 ? round(($wonDeals / $totalDeals) * 100, 1) : 0;
        $avgDealSize = $wonDeals > 0 ? round($totalValue / $wonDeals, 2) : 0;

        return compact('totalDeals', 'wonDeals', 'totalValue', 'winRate', 'avgDealSize');
    }
}
