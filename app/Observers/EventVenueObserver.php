<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\Event;
use App\Models\EventVenue;

class EventVenueObserver
{
    public function created(EventVenue $venue): void
    {
        if ($venue->is_primary) {
            $this->syncEventVenue($venue->event);
        }
    }

    public function updated(EventVenue $venue): void
    {
        if ($venue->is_primary || $venue->wasChanged('is_primary')) {
            $this->syncEventVenue($venue->event);
        }
    }

    public function deleted(EventVenue $venue): void
    {
        $this->syncEventVenue($venue->event);
    }

    /**
     * Sync the parent event's summary columns from the primary venue.
     */
    protected function syncEventVenue(Event $event): void
    {
        // Find the primary venue, or fall back to the first one
        $primaryVenue = $event->venues()->primary()->first()
            ?? $event->venues()->ordered()->first();

        if (! $primaryVenue) {
            $event->updateQuietly([
                'venue' => null,
                'city' => null,
                'state' => null,
                'country' => null,
                'primary_latitude' => null,
                'primary_longitude' => null,
            ]);

            return;
        }

        $event->updateQuietly([
            'venue' => $primaryVenue->venue_name,
            'city' => $primaryVenue->city,
            'state' => $primaryVenue->state,
            'country' => $primaryVenue->country,
            'primary_latitude' => $primaryVenue->latitude,
            'primary_longitude' => $primaryVenue->longitude,
        ]);
    }
}
