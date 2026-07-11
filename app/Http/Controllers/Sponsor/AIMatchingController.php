<?php

declare(strict_types=1);

namespace App\Http\Controllers\Sponsor;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Sponsor;
use App\Models\SponsorBudget;
use App\Models\SponsorProposal;
use App\Models\SponsorSavedEvent;
use App\Services\Sponsor\AIRecommendationService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AIMatchingController extends Controller
{
    public function __construct(
        private readonly AIRecommendationService $recommendationService
    ) {}

    public function index(Request $request): View
    {
        $userId = auth()->id();
        $sponsor = Sponsor::where('user_id', $userId)->first();

        $filters = $request->only(['industry', 'budget_max', 'location']);

        $recommendations = $this->recommendationService->getRecommendations($userId, $filters);

        $appliedIds = SponsorProposal::where('sponsor_id', $userId)->pluck('event_id')->unique()->toArray();
        $savedIds = SponsorSavedEvent::where('sponsor_id', $userId)->pluck('event_id')->toArray();

        $pastEvents = $sponsor
            ? SponsorProposal::where('sponsor_id', $userId)
                ->with('event')
                ->whereIn('status', ['completed', 'active', 'contracted'])
                ->get()
            : collect();

        $budget = SponsorBudget::where('sponsor_id', $userId)
            ->where('fiscal_year', date('Y'))
            ->first();

        $industries = Category::pluck('name', 'id');

        return view('sponsor.ai-matching.index', compact(
            'recommendations', 'appliedIds', 'savedIds',
            'pastEvents', 'budget', 'industries', 'filters'
        ));
    }
}
