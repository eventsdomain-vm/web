<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\SponsorAnnouncement;
use App\Models\SponsorBrandAsset;
use App\Models\SponsorCampaign;
use App\Models\SponsorDocument;
use App\Models\SponsorIntegration;
use App\Models\SponsorInvoice;
use App\Models\SponsorshipContract;
use App\Models\SponsorTask;
use App\Models\SponsorTeam;
use App\Models\User;

class SponsorWorkspacePolicy
{
    protected function ownsSponsor(User $user, int $sponsorId): bool
    {
        return $user->id === $sponsorId;
    }

    protected function isTeamMember(User $user, int $sponsorId): bool
    {
        return $user->sponsorTeamMembers()->where('sponsor_id', $sponsorId)->exists();
    }

    // =========================================================================
    // Campaign
    // =========================================================================

    public function viewCampaign(User $user, SponsorCampaign $campaign): bool
    {
        return $this->ownsSponsor($user, $campaign->sponsor_id);
    }

    public function updateCampaign(User $user, SponsorCampaign $campaign): bool
    {
        return $this->ownsSponsor($user, $campaign->sponsor_id);
    }

    // =========================================================================
    // Contract
    // =========================================================================

    public function viewContract(User $user, SponsorshipContract $contract): bool
    {
        return $this->ownsSponsor($user, $contract->sponsor_id);
    }

    public function signContract(User $user, SponsorshipContract $contract): bool
    {
        return $this->ownsSponsor($user, $contract->sponsor_id)
            && $contract->status === 'pending_signature';
    }

    // =========================================================================
    // Invoice
    // =========================================================================

    public function viewInvoice(User $user, SponsorInvoice $invoice): bool
    {
        return $this->ownsSponsor($user, $invoice->sponsor_id);
    }

    public function payInvoice(User $user, SponsorInvoice $invoice): bool
    {
        return $this->ownsSponsor($user, $invoice->sponsor_id)
            && ! in_array($invoice->status, ['paid', 'cancelled', 'refunded']);
    }

    // =========================================================================
    // Team
    // =========================================================================

    public function viewTeam(User $user, SponsorTeam $team): bool
    {
        return $this->ownsSponsor($user, $team->sponsor_id);
    }

    public function manageTeam(User $user, SponsorTeam $team): bool
    {
        return $this->ownsSponsor($user, $team->sponsor_id);
    }

    // =========================================================================
    // Task
    // =========================================================================

    public function viewTask(User $user, SponsorTask $task): bool
    {
        return $this->ownsSponsor($user, $task->sponsor_id);
    }

    public function updateTask(User $user, SponsorTask $task): bool
    {
        return $this->ownsSponsor($user, $task->sponsor_id);
    }

    // =========================================================================
    // Brand Asset
    // =========================================================================

    public function viewBrandAsset(User $user, SponsorBrandAsset $asset): bool
    {
        return $this->ownsSponsor($user, $asset->brand->sponsor_id);
    }

    // =========================================================================
    // Document
    // =========================================================================

    public function viewDocument(User $user, SponsorDocument $document): bool
    {
        return $this->ownsSponsor($user, $document->sponsor_id);
    }

    public function manageDocument(User $user, SponsorDocument $document): bool
    {
        return $this->ownsSponsor($user, $document->sponsor_id);
    }

    // =========================================================================
    // Announcement
    // =========================================================================

    public function viewAnnouncement(User $user, SponsorAnnouncement $announcement): bool
    {
        return $this->ownsSponsor($user, $announcement->sponsor_id);
    }

    public function publishAnnouncement(User $user, SponsorAnnouncement $announcement): bool
    {
        return $this->ownsSponsor($user, $announcement->sponsor_id);
    }

    // =========================================================================
    // Integration
    // =========================================================================

    public function viewIntegration(User $user, SponsorIntegration $integration): bool
    {
        return $this->ownsSponsor($user, $integration->sponsor_id);
    }

    public function manageIntegration(User $user, SponsorIntegration $integration): bool
    {
        return $this->ownsSponsor($user, $integration->sponsor_id);
    }
}
