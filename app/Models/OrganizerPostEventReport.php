<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrganizerPostEventReport extends Model
{
    protected $fillable = [
        'user_id', 'event_id', 'total_attendance', 'sponsor_booth_visits',
        'lead_generated', 'sponsor_satisfaction', 'roi_percentage',
        'revenue_generated', 'expenses_incurred',
        'deliverable_fulfillment', 'media_coverage', 'feedback_data',
        'lessons_learned', 'improvement_notes', 'status', 'submitted_at',
    ];

    protected function casts(): array
    {
        return [
            'total_attendance' => 'integer',
            'sponsor_booth_visits' => 'integer',
            'lead_generated' => 'integer',
            'sponsor_satisfaction' => 'decimal:1',
            'roi_percentage' => 'decimal:1',
            'revenue_generated' => 'decimal:2',
            'expenses_incurred' => 'decimal:2',
            'deliverable_fulfillment' => 'array',
            'media_coverage' => 'array',
            'feedback_data' => 'array',
            'submitted_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}
