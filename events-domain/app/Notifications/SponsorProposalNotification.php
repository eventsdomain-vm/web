<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SponsorProposalNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public string $eventTitle,
        public array $statusChanges,
        public int $proposalId,
    ) {}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("Proposal Status Update: {$this->eventTitle}")
            ->line("The status of your proposal for \"{$this->eventTitle}\" has been updated.")
            ->line($this->getStatusText())
            ->action('View Proposal', route('sponsor.proposals.show', $this->proposalId))
            ->line('Thank you for participating in our event marketplace!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'event_title' => $this->eventTitle,
            'proposal_id' => $this->proposalId,
            'status_changes' => $this->statusChanges,
            'status_text' => $this->getStatusText(),
        ];
    }

    /**
     * Get human-readable status change text.
     */
    protected function getStatusText(): string
    {
        $from = $this->statusChanges['from'] ?? 'unknown';
        $to = $this->statusChanges['to'] ?? 'unknown';

        $mappings = [
            'draft' => ['submitted', 'created a draft proposal', 'updated'],
            'submitted' => [' viewed', ' viewed and noted'],
            'viewed' => [' shortlisted', ' shortlisted'],
            'shortlisted' => [' negotiating', ' in negotiation'],
            'negotiating' => [' counter_offer', ' sent a counter offer'],
            'counter_offer' => [' agreed', ' accepted your counter offer'],
            'agreed' => [' contracted', ' agreed and ready for contracting'],
            'contracted' => [' active', ' signed and active'],
            'active' => [' completed', ' concluded successfully'],
            'completed' => [' rejected', ' withdrew or rejected'],
            'rejected' => [' withdrawn', ' withdrew'],
            'withdrawn' => ['commented', 'commented'],
        ];

        $action = ($mappings[$to] ?? [])[$from] ?? [];
        $fromLabel = $this->getStatusLabel($from);
        $toLabel = $this->getStatusLabel($to);

        if (! $action) {
            return "Your proposal status changed from \"{$fromLabel}\" to \"{$toLabel}\".";
        }

        $actionWord = is_array($action) && isset($action[0]) ? $action[0] : $action;
        $actionText = is_array($action) && count($action) > 1 ? $action[1] : $actionWord;

        return "Your proposal \"{$this->eventTitle}\" {$actionText}. Changed from \"{$fromLabel}\" to \"{$toLabel}\".";
    }

    /**
     * Get user-friendly status label.
     */
    protected function getStatusLabel(string $status): string
    {
        $mapping = [
            'draft' => 'Draft',
            'submitted' => 'Submitted',
            'viewed' => 'Viewed',
            'shortlisted' => 'Shortlisted',
            'negotiating' => 'Negotiating',
            'counter_offer' => 'Counter Offer',
            'agreed' => 'Agreed',
            'contracted' => 'Contracted',
            'payment_pending' => 'Payment Pending',
            'active' => 'Active',
            'completed' => 'Completed',
            'rejected' => 'Rejected',
            'withdrawn' => 'Withdrawn',
        ];

        return $mapping[$to] ?? ucfirst($to);
    }
}
