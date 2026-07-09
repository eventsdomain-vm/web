<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\SponsorProposal;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProposalRejectedNotification extends Notification implements ShouldQueue
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
            ->subject('Sponsorship Proposal Update - ' . $this->proposal->event->title)
            ->greeting('Proposal Update')
            ->line('Your sponsorship proposal for ' . $this->proposal->event->title . ' has been reviewed.')
            ->when($this->proposal->organizer_note, function ($message) {
                return $message->line('Feedback: ' . $this->proposal->organizer_note);
            })
            ->action('View Proposal', route('sponsor.proposals.show', $this->proposal))
            ->line('You can submit a new proposal or explore other opportunities.');
    }

    public function toArray($notifiable): array
    {
        return [
            'proposal_id' => $this->proposal->id,
            'event_title' => $this->proposal->event->title,
            'status' => 'rejected',
            'message' => 'Your proposal for ' . $this->proposal->event->title . ' has been rejected.',
        ];
    }
}
