<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\SponsorCampaign;
use App\Models\SponsorCampaignDeliverable;
use App\Models\SponsorCampaignMilestone;
use Illuminate\Support\Facades\DB;

class SponsorCampaignService
{
    public function createCampaign(array $data): SponsorCampaign
    {
        return DB::transaction(function () use ($data) {
            $campaign = SponsorCampaign::create($data);

            if (! empty($data['milestones'])) {
                $this->syncMilestones($campaign, $data['milestones']);
            }

            return $campaign;
        });
    }

    public function updateCampaign(SponsorCampaign $campaign, array $data): SponsorCampaign
    {
        DB::transaction(function () use ($campaign, $data) {
            $campaign->update($data);

            if (isset($data['milestones'])) {
                $campaign->milestones()->delete();
                $this->syncMilestones($campaign, $data['milestones']);
            }
        });

        return $campaign->fresh();
    }

    public function addDeliverable(SponsorCampaign $campaign, array $data): SponsorCampaignDeliverable
    {
        $data['campaign_id'] = $campaign->id;

        return SponsorCampaignDeliverable::create($data);
    }

    public function updateDeliverable(SponsorCampaignDeliverable $deliverable, array $data): SponsorCampaignDeliverable
    {
        $deliverable->update($data);

        return $deliverable->fresh();
    }

    public function addMilestone(SponsorCampaign $campaign, array $data): SponsorCampaignMilestone
    {
        $data['campaign_id'] = $campaign->id;

        return SponsorCampaignMilestone::create($data);
    }

    public function completeMilestone(SponsorCampaignMilestone $milestone): void
    {
        $milestone->update(['completed_at' => now()]);
    }

    public function getCampaignProgress(SponsorCampaign $campaign): array
    {
        $totalDeliverables = $campaign->deliverables()->count();
        $completedDeliverables = $campaign->deliverables()
            ->whereIn('status', ['completed', 'cancelled'])
            ->count();

        $totalMilestones = $campaign->milestones()->count();
        $completedMilestones = $campaign->milestones()
            ->whereNotNull('completed_at')
            ->count();

        return [
            'deliverables_progress' => $totalDeliverables > 0
                ? round(($completedDeliverables / $totalDeliverables) * 100)
                : 0,
            'milestones_progress' => $totalMilestones > 0
                ? round(($completedMilestones / $totalMilestones) * 100)
                : 0,
            'budget_utilization' => $campaign->budget > 0
                ? round(($campaign->spent / $campaign->budget) * 100)
                : 0,
            'roi' => $campaign->roi,
        ];
    }

    protected function syncMilestones(SponsorCampaign $campaign, array $milestones): void
    {
        foreach ($milestones as $order => $milestone) {
            $campaign->milestones()->create([
                'title' => $milestone['title'],
                'description' => $milestone['description'] ?? null,
                'due_date' => $milestone['due_date'] ?? null,
                'sort_order' => $order,
            ]);
        }
    }
}
