<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventAudience extends Model
{
    protected $table = 'event_audience';

    protected $fillable = [
        'event_id',
        'audience_types',
        'age_groups',
        'gender_composition',
        'income_level',
        'industry_alignment',
    ];

    protected $casts = [
        'audience_types' => 'array',
        'age_groups' => 'array',
        'industry_alignment' => 'array',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}
