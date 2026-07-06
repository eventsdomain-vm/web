<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventSchedule extends Model
{
    use HasFactory;

    protected $table = 'event_schedule';

    protected $fillable = [
        'event_id',
        'event_date_id',
        'stage_id',
        'title',
        'description',
        'start_time',
        'end_time',
        'speaker',
        'venue',
        'sort_order',
    ];

    protected $casts = [
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
        'sort_order' => 'integer',
    ];

    // =========================================================================
    // Relationships
    // =========================================================================

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function eventDate(): BelongsTo
    {
        return $this->belongsTo(EventDate::class);
    }

    public function stage(): BelongsTo
    {
        return $this->belongsTo(EventStage::class, 'stage_id');
    }

    // =========================================================================
    // Helpers
    // =========================================================================

    public function getDurationAttribute(): string
    {
        $start = Carbon::parse($this->start_time);
        $end = Carbon::parse($this->end_time);
        $minutes = $start->diffInMinutes($end);

        if ($minutes >= 60) {
            $hours = floor($minutes / 60);
            $remainingMinutes = $minutes % 60;

            return $remainingMinutes > 0 ? "{$hours}h {$remainingMinutes}m" : "{$hours}h";
        }

        return "{$minutes}m";
    }
}
