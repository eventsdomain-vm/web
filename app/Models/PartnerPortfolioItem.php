<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PartnerPortfolioItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'partner_id',
        'title',
        'description',
        'event_name',
        'event_date',
        'location',
        'images',
        'video_url',
        'tags',
        'is_featured',
    ];

    protected function casts(): array
    {
        return [
            'event_date' => 'date',
            'images' => 'array',
            'tags' => 'array',
            'is_featured' => 'boolean',
        ];
    }

    public function partner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'partner_id');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }
}
