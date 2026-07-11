<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class ParticipantType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'sort_order',
    ];

    protected $casts = [
        'sort_order' => 'integer',
    ];

    public function eventParticipants()
    {
        return $this->hasMany(EventParticipant::class);
    }

    public static function cachedAll(): Collection
    {
        return Cache::remember('participant_types_all', 3600, function () {
            return static::orderBy('sort_order')->get();
        });
    }

    public static function flushCache(): void
    {
        Cache::forget('participant_types_all');
    }
}
