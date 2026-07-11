<?php

declare(strict_types=1);

namespace App\Http\Controllers\Sponsor;

use App\Http\Controllers\Controller;
use App\Models\Sponsor;
use App\Models\SponsorObjective;
use App\Models\SponsorPreference;
use App\Models\SponsorBudgetAllocation;
use App\Services\Sponsor\SponsorProfileService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SponsorPlanController extends Controller
{
    public function __construct(
        protected SponsorProfileService $profileService,
    ) {}

    public function index(): View
    {
        $sponsor = $this->getSponsor();
        $profile = $this->profileService->getFullSponsorProfile($sponsor->user_id);

        $planStatus = $this->profileService->getPlanStatus($sponsor->id);
        $objectives = $sponsor->objectives()->orderBy('sort_order')->latest()->get();

        return view('sponsor.plan.index', compact('sponsor', 'profile', 'planStatus', 'objectives'));
    }

    public function objectives(): View
    {
        $sponsor = $this->getSponsor();
        $objectives = $sponsor->objectives()->orderBy('sort_order')->latest()->get();
        $objectiveTypes = ['brand_awareness', 'lead_generation', 'sales_conversion', 'csr', 'product_launch', 'market_entry', 'other'];

        return view('sponsor.plan.objectives.index', compact('sponsor', 'objectives', 'objectiveTypes'));
    }

    public function storeObjective(Request $request): RedirectResponse
    {
        $sponsor = $this->getSponsor();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'objective_type' => 'required|in:brand_awareness,lead_generation,sales_conversion,csr,product_launch,market_entry,other',
            'target_kpi_value' => 'nullable|numeric',
            'kpi_unit' => 'nullable|string|max:50',
            'estimated_cost' => 'nullable|numeric',
            'estimated_roi' => 'nullable|numeric',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0|max:999',
        ]);

        $objective = SponsorObjective::create(array_merge($validated, ['sponsor_id' => $sponsor->id]));

        return redirect()->route('sponsor.plan.objectives')
            ->with('success', 'Objective created successfully!');
    }

    public function createBudget(Request $request): JsonResponse
    {
        $sponsor = $this->getSponsor();

        $validated = $request->validate([
            'fiscal_year' => 'required|string|regex:/^[0-9]{4}$/',
            'category_allocations' => 'nullable|array',
            'total_budget' => 'required|numeric|min:0',
            'status' => 'required|in:draft,approved,active,closed',
            'valid_from' => 'nullable|date',
            'valid_to' => 'nullable|date',
        ]);

        $validated['category_allocations'] = $this->normalizeCategoryAllocations($validated['category_allocations'] ?? null);

        SponsorBudgetAllocation::create(array_merge($validated, ['sponsor_id' => $sponsor->id]));

        return response()->json(['message' => 'Budget allocation created successfully']);
    }

    public function updateBudget(Request $request, SponsorBudgetAllocation $allocation): JsonResponse
    {
        $sponsor = $this->getSponsor();

        if ($allocation->sponsor_id !== $sponsor->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'fiscal_year' => 'required|string|regex:/^[0-9]{4}$/',
            'category_allocations' => 'nullable|array',
            'total_budget' => 'required|numeric|min:0',
            'status' => 'required|in:draft,approved,active,closed',
            'valid_from' => 'nullable|date',
            'valid_to' => 'nullable|date',
        ]);

        $validated['category_allocations'] = $this->normalizeCategoryAllocations($validated['category_allocations'] ?? null);

        $allocation->update($validated);

        return response()->json(['message' => 'Budget allocation updated successfully']);
    }

    public function deleteBudget(SponsorBudgetAllocation $allocation): JsonResponse
    {
        $sponsor = $this->getSponsor();

        if ($allocation->sponsor_id !== $sponsor->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $allocation->delete();

        return response()->json(['message' => 'Budget allocation deleted successfully']);
    }

    private function normalizeCategoryAllocations(?array $value): array
    {
        if (empty($value)) {
            return [];
        }

        $normalized = [];
        foreach ($value as $category => $amount) {
            $category = is_string($category) ? trim($category) : $category;
            if ($category === '' || $category === null) {
                continue;
            }
            $normalized[$category] = is_numeric($amount) ? (float) $amount : 0;
        }

        return $normalized;
    }

    public function updateObjective(Request $request, SponsorObjective $objective): RedirectResponse
    {
        $sponsor = $this->getSponsor();

        if ($objective->sponsor_id !== $sponsor->id) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'objective_type' => 'sometimes|required|in:brand_awareness,lead_generation,sales_conversion,csr,product_launch,market_entry,other',
            'target_kpi_value' => 'sometimes|nullable|numeric',
            'kpi_unit' => 'sometimes|nullable|string|max:50',
            'estimated_cost' => 'sometimes|nullable|numeric',
            'estimated_roi' => 'sometimes|nullable|numeric',
            'is_active' => 'sometimes|boolean',
            'sort_order' => 'sometimes|integer|min:0|max:999',
        ]);

        $objective->update($validated);

        return redirect()->route('sponsor.plan.objectives')
            ->with('success', 'Objective updated successfully!');
    }

    public function destroyObjective(SponsorObjective $objective): RedirectResponse
    {
        $sponsor = $this->getSponsor();

        if ($objective->sponsor_id !== $sponsor->id) {
            abort(403, 'Unauthorized');
        }

        $objective->delete();

        return redirect()->route('sponsor.plan.objectives')
            ->with('success', 'Objective deleted successfully!');
    }

    public function preferences(): View
    {
        $sponsor = $this->getSponsor();
        $preferences = $sponsor->preferences()->first();

        $eventTypes = ['physical', 'virtual', 'hybrid', 'digital'];
        $formatOptions = ['title', 'presenting', 'booth', 'digital', 'virtual', 'sponsorship_rights'];
        $industryList = ['Technology', 'Healthcare', 'Financial Services', 'Retail & E-commerce', 'Media & Entertainment', 'Automotive', 'Travel & Hospitality', 'Education', 'Sports & Fitness', 'Manufacturing'];

        return view('sponsor.plan.preferences.index', compact('sponsor', 'preferences', 'eventTypes', 'formatOptions', 'industryList'));
    }

    public function updatePreferences(Request $request): RedirectResponse
    {
        $sponsor = $this->getSponsor();

        $validated = $request->validate([
            'target_audience_demographics' => 'nullable|array',
            'category_preferences' => 'nullable|string',
            'event_types' => 'nullable|array',
            'geographic_preferences' => 'nullable|string',
            'budget_range' => 'nullable|array',
            'formats_preferred' => 'nullable|array',
            'industry_targets' => 'nullable|array',
            'min_audience_size' => 'nullable|integer|min:0|max:1000000',
            'max_audience_size' => 'nullable|integer|min:0|max:1000000',
            'notes' => 'nullable|string',
        ]);

        $normalizeList = function ($value): array {
            if (is_array($value)) {
                return array_values(array_filter(array_map('trim', $value)));
            }
            if (is_string($value)) {
                return array_values(array_filter(array_map('trim', explode(',', $value))));
            }
            return [];
        };

        $validated['category_preferences'] = $normalizeList($validated['category_preferences'] ?? null);
        $validated['geographic_preferences'] = $normalizeList($validated['geographic_preferences'] ?? null);

        $preferences = $sponsor->preferences()->first() ?: new SponsorPreference(['sponsor_id' => $sponsor->id]);

        $preferences->fill($validated);
        $preferences->save();

        return redirect()->route('sponsor.plan.preferences')
            ->with('success', 'Your preferences have been saved successfully!');
    }

    public function budgets(): View
    {
        $sponsor = $this->getSponsor();
        $budgetAllocations = $sponsor->budgetAllocations()->orderBy('fiscal_year', 'desc')->get();
        $planStatus = $this->profileService->getPlanStatus($sponsor->id);

        return view('sponsor.plan.budgets.index', compact('sponsor', 'budgetAllocations', 'planStatus'));
    }

    public function generateAiRecommendations(): JsonResponse
    {
        $sponsor = $this->getSponsor();
        $profile = $this->profileService->getFullSponsorProfile($sponsor->user_id);

        $recommendations = $this->generateRecommendations($profile, $sponsor);

        return response()->json(['recommendations' => $recommendations]);
    }

    private function getSponsor(): Sponsor
    {
        return Sponsor::where('user_id', auth()->id())->firstOrFail();
    }

    private function generateRecommendations(array $profile, Sponsor $sponsor): array
    {
        $recommendations = [
            'optimize_budget_allocation' => [
                'message' => 'Based on your sponsorship objectives, consider allocating more budget to lead_generation objectives',
                'impact' => 'high',
                'potential_roi' => '+23%',
            ],
            'target_audience_refinement' => [
                'message' => 'Your target audience demographics could be refined for better event matching',
                'impact' => 'medium',
                'potential_roi' => '+15%',
            ],
            'event_type_expansion' => [
                'message' => 'Consider expanding to virtual/hybrid events to reach wider audience',
                'impact' => 'medium',
                'potential_roi' => '+8%',
            ],
        ];

        return $recommendations;
    }
}
