<?php

declare(strict_types=1);

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\PartnerLead;
use App\Services\Partner\PartnerAICopilotService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AICopilotController extends Controller
{
    public function __construct(
        protected PartnerAICopilotService $aiService,
    ) {}

    public function index()
    {
        $partnerId = Auth::id();
        $recommendations = $this->aiService->opportunityRecommendations($partnerId, 10);
        $forecast = $this->aiService->revenueForecast($partnerId);

        return view('partner.ai-copilot.index', compact('recommendations', 'forecast'));
    }

    public function scoreLead(Request $request)
    {
        $lead = PartnerLead::where('partner_id', Auth::id())->findOrFail($request->lead_id);
        $scoring = $this->aiService->leadScoring($lead);

        if ($request->ajax()) {
            return response()->json($scoring);
        }

        return back()->with('scoring', $scoring);
    }
}
