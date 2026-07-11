<?php

declare(strict_types=1);

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Services\Partner\PartnerAICopilotService;
use App\Services\Partner\PartnerDashboardService;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct(
        protected PartnerDashboardService $dashboardService,
        protected PartnerAICopilotService $aiService,
    ) {}

    public function index()
    {
        $partnerId = Auth::id();

        $kpis = $this->dashboardService->kpis($partnerId);
        $revenueTrend = $this->dashboardService->revenueTrend($partnerId);
        $pipelineFunnel = $this->dashboardService->pipelineFunnel($partnerId);
        $tasks = $this->dashboardService->tasks($partnerId);
        $activities = $this->dashboardService->recentActivities($partnerId);
        $recommendations = $this->aiService->opportunityRecommendations($partnerId);
        $forecast = $this->aiService->revenueForecast($partnerId);

        return view('partner.dashboard-new', compact(
            'kpis', 'revenueTrend', 'pipelineFunnel',
            'tasks', 'activities', 'recommendations', 'forecast',
        ));
    }
}
