<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\Event;
use App\Models\EventDate;
use Carbon\Carbon;

class EventDateObserver
{
    public function created(EventDate $eventDate): void
    {
        $this->syncEventDates($eventDate->event);
    }

    public function updated(EventDate $eventDate): void
    {
        $this->syncEventDates($eventDate->event);
    }

    public function deleted(EventDate $eventDate): void
    {
        $this->syncEventDates($eventDate->event);
    }

    /**
     * Sync the parent event's summary columns from event_dates.
     */
    protected function syncEventDates(Event $event): void
    {
        $dates = $event->dates()->ordered()->get();

        if ($dates->isEmpty()) {
            $event->updateQuietly([
                'start_date' => null,
                'end_date' => null,
                'next_occurrence_at' => null,
            ]);

            return;
        }

        $firstDate = $dates->first();
        $lastDate = $dates->last();

        // Build start_date from earliest date
        $startDate = $firstDate->start_date;
        if ($firstDate->start_time) {
            $timeStr = $firstDate->start_time instanceof Carbon
                ? $firstDate->start_time->format('H:i:s')
                : $firstDate->start_time;
            $startDate = $startDate->setTimeFromTimeString($timeStr);
        }

        // Build end_date from latest date
        $endDate = $lastDate->end_date ?? $lastDate->start_date;
        if ($lastDate->end_time) {
            $timeStr = $lastDate->end_time instanceof Carbon
                ? $lastDate->end_time->format('H:i:s')
                : $lastDate->end_time;
            $endDate = $endDate->setTimeFromTimeString($timeStr);
        } elseif ($firstDate->end_time && $dates->count() === 1) {
            $timeStr = $firstDate->end_time instanceof Carbon
                ? $firstDate->end_time->format('H:i:s')
                : $firstDate->end_time;
            $endDate = $endDate->setTimeFromTimeString($timeStr);
        }

        // Find next future occurrence
        $nextOccurrence = $dates
            ->where('start_date', '>=', now()->toDateString())
            ->sortBy('start_date')
            ->first();

        $nextOccurrenceAt = null;
        if ($nextOccurrence) {
            $nextOccurrenceAt = $nextOccurrence->start_date;
            if ($nextOccurrence->start_time) {
                $timeStr = $nextOccurrence->start_time instanceof Carbon
                    ? $nextOccurrence->start_time->format('H:i:s')
                    : $nextOccurrence->start_time;
                $nextOccurrenceAt = $nextOccurrenceAt->setTimeFromTimeString($timeStr);
            }
        }

        $event->updateQuietly([
            'start_date' => $startDate,
            'end_date' => $endDate,
            'next_occurrence_at' => $nextOccurrenceAt,
        ]);
    }
}
