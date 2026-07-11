<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrganizerSetting extends Model
{
    protected $fillable = [
        'user_id', 'locale', 'timezone', 'currency',
        'notification_preferences', 'reporting_preferences', 'marketplace_preferences',
    ];

    protected function casts(): array
    {
        return [
            'notification_preferences' => 'array',
            'reporting_preferences' => 'array',
            'marketplace_preferences' => 'array',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
