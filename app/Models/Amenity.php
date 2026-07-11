<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class Amenity extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'icon',
        'group',
        'sort_order',
    ];

    protected $casts = [
        'sort_order' => 'integer',
    ];

    public static function cachedAll(): Collection
    {
        return Cache::remember('amenities_all', 3600, function () {
            return static::orderBy('sort_order')->get();
        });
    }

    public static function flushCache(): void
    {
        Cache::forget('amenities_all');
    }
}
