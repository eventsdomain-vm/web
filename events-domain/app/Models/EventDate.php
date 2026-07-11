<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventDate extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'label',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'timezone',
        'all_day',
        'sort_order',
        'recurrence_rule',
        'recurrence_until',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
        'all_day' => 'boolean',
        'sort_order' => 'integer',
        'recurrence_until' => 'date',
    ];

    // =========================================================================
    // Relationships
    // =========================================================================

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    // =========================================================================
    // Scopes
    // =========================================================================

    public function scopeOrdered($query)
    {
        return $query->orderBy('start_date')->orderBy('start_time');
    }

    public function scopeUpcoming($query)
    {
        return $query->where('start_date', '>=', now()->toDateString());
    }

    // =========================================================================
    // Helpers
    // =========================================================================

    public function getDurationAttribute(): ?string
    {
        if (! $this->start_time || ! $this->end_time) {
            return null;
        }

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
