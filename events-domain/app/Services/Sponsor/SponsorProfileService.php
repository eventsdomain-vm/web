<?php

namespace App\Services\Sponsor;

use App\Models\Sponsor;

class SponsorProfileService
{
    public function getFullSponsorProfile(int $userId): array
    {
        $sponsor = Sponsor::where('user_id', $userId)->first();

        if (! $sponsor) {
            return [
                'has_profile' => false,
                'profile_complete' => false,
                'completion_percentage' => 0,
                'next_steps' => ['Create your sponsor profile'],
            ];
        }

        $profile = [
            'id' => $sponsor->id,
            'name' => $sponsor->name,
            'logo' => $sponsor->logo,
            'website' => $sponsor->website,
            'industry' => $sponsor->industry,
            'org_type' => $sponsor->org_type,
            'registration_number' => $sponsor->registration_number,
            'tax_id' => $sponsor->tax_id,
            'business_email' => $sponsor->business_email,
            'business_phone' => $sponsor->business_phone,
            'timezone' => $sponsor->timezone,
            'default_currency' => $sponsor->default_currency,
            'fiscal_year' => $sponsor->fiscal_year,
            'org_status' => $sponsor->org_status,
            'description' => $sponsor->description,
            'social_links' => $sponsor->social_links,
            'is_verified' => $sponsor->is_verified,
            'sso_enabled' => $sponsor->sso_enabled,
        ];

        $planStatus = $this->getPlanStatus($sponsor->id);

        $isComplete = $this->checkProfileCompleteness($sponsor);

        $nextSteps = $this->getNextSteps($sponsor, $planStatus);

        return [
            'profile' => $profile,
            'plan_status' => $planStatus,
            'is_complete' => $isComplete,
            'completion_percentage' => $this->calculateCompletionPercentage($sponsor, $planStatus),
            'next_steps' => $nextSteps,
        ];
    }

    public function getPlanStatus(int $sponsorId): array
    {
        $sponsor = Sponsor::with(['objectives', 'preferences', 'budgetAllocations', 'campaigns', 'contracts'])->find($sponsorId);

        return [
            'objectives' => [
                'count' => $sponsor->objectives->count(),
                'has_primary_objective' => $sponsor->objectives->where('objective_type', 'lead_generation')->isNotEmpty(),
                'primary_objective' => $sponsor->objectives->where('objective_type', 'lead_generation')->values(),
                'has_budget_objective' => $sponsor->objectives->where('objective_type', 'sales_conversion')->isNotEmpty(),
                'budget_objective' => $sponsor->objectives->where('objective_type', 'sales_conversion')->values(),
            ],
            'preferences' => [
                'exists' => $sponsor->preferences->isNotEmpty(),
                'industry_targets' => $sponsor->preferences->first()?->industry_targets,
                'category_preferences' => $sponsor->preferences->first()?->category_preferences,
            ],
            'budget' => [
                'has_allocation' => $sponsor->budgetAllocations->isNotEmpty(),
                'current_fiscal_year' => $sponsor->budgetAllocations->where('status', 'active')->first(),
                'total_budget' => $sponsor->budgetAllocations->sum(fn ($b) => $b->total_budget),
                'allocated_so_far' => $sponsor->budgetAllocations->sum(fn ($b) => $b->allocated_so_far),
            ],
            'campaigns' => [
                'total' => $sponsor->campaigns->count(),
                'active' => $sponsor->campaigns->where('status', 'active')->count(),
            ],
            'contracts' => [
                'total' => $sponsor->contracts->count(),
                'signed' => $sponsor->contracts->where('signed_at')->count(),
            ],
            'subscribed_to_ai_matching' => $sponsor->objectives->where('objective_type', 'lead_generation')->isNotEmpty(),
        ];
    }

    private function checkProfileCompleteness(Sponsor $sponsor): bool
    {
        $checks = [
            !empty($sponsor->name),
            !empty($sponsor->industry),
            !empty($sponsor->org_type),
            $sponsor->objectives->isNotEmpty(),
            $sponsor->preferences->isNotEmpty(),
            $sponsor->budgetAllocations->isNotEmpty(),
        ];

        return collect($checks)->filter()->count() >= 4;
    }

    private function getNextSteps(Sponsor $sponsor, array $planStatus): array
    {
        $steps = [];

        if (empty($sponsor->name)) {
            $steps[] = 'Complete your organization profile';
        }

        if ($sponsor->objectives->isEmpty()) {
            $steps[] = 'Define sponsorship objectives and targets';
        }

        if (!$planStatus['subscribed_to_ai_matching']) {
            $steps[] = 'Activate AI matching with your objectives';
        }

        return $steps;
    }

    private function calculateCompletionPercentage(Sponsor $sponsor, array $planStatus): int
    {
        $totalChecks = 8;
        $completedChecks = 0;

        if (!empty($sponsor->name)) $completedChecks++;
        if (!empty($sponsor->industry)) $completedChecks++;
        if ($sponsor->objectives->isNotEmpty()) $completedChecks++;
        if ($sponsor->preferences->isNotEmpty()) $completedChecks++;
        if ($sponsor->budgetAllocations->isNotEmpty()) $completedChecks++;
        if ($sponsor->social_links) $completedChecks++;
        if ($sponsor->is_verified) $completedChecks++;
        if ($planStatus['subscribed_to_ai_matching']) $completedChecks++;

        return (int) round(($completedChecks / $totalChecks) * 100);
    }
}
