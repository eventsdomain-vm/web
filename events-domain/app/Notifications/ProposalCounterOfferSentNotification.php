<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\SponsorProposal;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProposalCounterOfferSentNotification extends Notification implements ShouldQueue
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
            ->subject('Counter Offer Received - ' . $this->proposal->event->title)
            ->greeting('Counter Offer Update')
            ->line('The organizer has sent a counter offer for ' . $this->proposal->event->title)
            ->line('Proposed Amount: ₹' . number_format($this->proposal->counter_amount ?? 0))
            ->when($this->proposal->counter_message, function ($message) {
                return $message->line('Message: ' . $this->proposal->counter_message);
            })
            ->action('Review Counter Offer', route('sponsor.proposals.show', $this->proposal))
            ->line('Accept the counter offer or send another counter proposal.');
    }

    public function toArray($notifiable): array
    {
        return [
            'proposal_id' => $this->proposal->id,
            'event_title' => $this->proposal->event->title,
            'status' => 'counter_offer',
            'counter_amount' => $this->proposal->counter_amount,
            'message' => 'Counter offer received for ' . $this->proposal->event->title . '.',
        ];
    }
}
