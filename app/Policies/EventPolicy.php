<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Event;
use App\Models\User;

class EventPolicy
{
    /**
     * Determine whether the user can view any events.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the event.
     */
    public function view(User $user, Event $event): bool
    {
        // Published events are public
        if ($event->is_published && $event->approval_status === 'approved') {
            return true;
        }

        // Organizer can view their own events
        if ($user->id === $event->organizer_id) {
            return true;
        }

        // Admin can view all events
        if ($user->hasRole('admin')) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can create events.
     */
    public function create(User $user): bool
    {
        return $user->hasAnyRole(['organizer', 'admin']);
    }

    /**
     * Determine whether the user can update the event.
     */
    public function update(User $user, Event $event): bool
    {
        // Organizer can update their own events
        if ($user->id === $event->organizer_id) {
            return true;
        }

        // Admin can update any event
        if ($user->hasRole('admin')) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the event.
     */
    public function delete(User $user, Event $event): bool
    {
        // Only draft or rejected events can be deleted
        if (! in_array($event->status, ['draft', 'rejected'])) {
            return false;
        }

        // Organizer can delete their own events
        if ($user->id === $event->organizer_id) {
            return true;
        }

        // Admin can delete any event
        if ($user->hasRole('admin')) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can publish/approve the event.
     */
    public function publish(User $user, Event $event): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can reject the event.
     */
    public function reject(User $user, Event $event): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can submit the event for review.
     */
    public function submitForReview(User $user, Event $event): bool
    {
        return $user->id === $event->organizer_id && $event->status === 'draft';
    }

    /**
     * Determine whether the user can manage packages for this event.
     */
    public function managePackages(User $user, Event $event): bool
    {
        return $user->id === $event->organizer_id || $user->hasRole('admin');
    }
}
