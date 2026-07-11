<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\SponsorProposal;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProposalNegotiationStartedNotification extends Notification implements ShouldQueue
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
            ->subject('Negotiation Started - ' . $this->proposal->event->title)
            ->greeting('Negotiation Update')
            ->line('The organizer has started negotiations for your sponsorship proposal for ' . $this->proposal->event->title)
            ->when($this->proposal->organizer_note, function ($message) {
                return $message->line('Organizer Note: ' . $this->proposal->organizer_note);
            })
            ->action('Respond with Counter Offer', route('sponsor.proposals.show', $this->proposal))
            ->line('Review the proposal and send your counter offer if needed.');
    }

    public function toArray($notifiable): array
    {
        return [
            'proposal_id' => $this->proposal->id,
            'event_title' => $this->proposal->event->title,
            'status' => 'negotiating',
            'message' => 'Negotiations started for ' . $this->proposal->event->title . '.',
        ];
    }
}
