<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\SponsorProposal;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProposalAcceptedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        protected SponsorProposal $proposal,
    ) {}

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Your Sponsorship Proposal Has Been Accepted!')
            ->greeting('Great News!')
            ->line('The organizer has accepted your sponsorship proposal for ' . $this->proposal->event->title)
            ->line('Amount: ₹' . number_format($this->proposal->budget_offer ?? $this->proposal->package->price ?? 0))
            ->action('View Proposal', route('sponsor.proposals.show', $this->proposal))
            ->line('Next step: Review and sign the sponsorship contract.');
    }

    public function toArray($notifiable): array
    {
        return [
            'proposal_id' => $this->proposal->id,
            'event_title' => $this->proposal->event->title,
            'status' => 'accepted',
            'message' => 'Your proposal for ' . $this->proposal->event->title . ' has been accepted.',
        ];
    }
}
