<?php

declare(strict_types=1);

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Services\Partner\PartnerReportService;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function __construct(
        protected PartnerReportService $reportService,
    ) {}

    public function index()
    {
        $partnerId = Auth::id();

        $revenue = $this->reportService->revenue($partnerId);
        $leadFunnel = $this->reportService->leadFunnel($partnerId);
        $conversion = $this->reportService->conversion($partnerId);
        $commission = $this->reportService->commission($partnerId);
        $campaignPerformance = $this->reportService->campaignPerformance($partnerId);
        $partnerPerformance = $this->reportService->partnerPerformance($partnerId);

        return view('partner.reports.index', compact(
            'revenue', 'leadFunnel', 'conversion',
            'commission', 'campaignPerformance', 'partnerPerformance',
        ));
    }
}
