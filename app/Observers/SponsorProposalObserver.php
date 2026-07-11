<?php

namespace App\Observers;

use App\Models\SponsorProposal;

class SponsorProposalObserver
{
    /**
     * Handle the SponsorProposal "updated" event.
     */
    public function updated(SponsorProposal $proposal): void
    {
        if ($proposal->wasChanged('status') && $proposal->sponsor) {
            $statusChanges = [
                'from' => $proposal->getOriginal('status'),
                'to' => $proposal->status,
            ];

            $proposal->sponsor->notify(new App\Notifications\SponsorProposalNotification(
                eventTitle: $proposal->event->title,
                statusChanges: $statusChanges,
                proposalId: $proposal->id,
            ));
        }
    }
}
