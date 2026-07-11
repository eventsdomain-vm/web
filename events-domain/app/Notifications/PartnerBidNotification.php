<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PartnerBidNotification extends Notification
{
    use Queueable;

    public function __construct(
        public string $eventTitle,
        public int $eventId,
        public string $bidStatus,
        public int $bidId,
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("Bid Update: {$this->eventTitle}")
            ->line("Your bid for \"{$this->eventTitle}\" has been updated.")
            ->line($this->getStatusText())
            ->action('View Bid', route('partner.bids.show', $this->bidId))
            ->line('Thank you for participating in our partner marketplace!');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'event_title' => $this->eventTitle,
            'event_id' => $this->eventId,
            'bid_status' => $this->bidStatus,
            'bid_id' => $this->bidId,
            'status_text' => $this->getStatusText(),
        ];
    }

    protected function getStatusText(): string
    {
        $status = $this->bidStatus;

        return match ($status) {
            'pending' => 'Your bid is pending review by the event organizer.',
            'accepted' => 'Congratulations! Your bid has been accepted.',
            'rejected' => 'Your bid has been reviewed and rejected.',
            'withdrawn' => 'Your bid has been withdrawn.',
            'negotiating' => 'The organizer is negotiating with you on this bid.',
            default => "Your bid status has been updated to '{$status}'.",
        };
    }
}
