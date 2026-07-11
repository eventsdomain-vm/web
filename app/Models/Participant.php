<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Participant extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'uuid',
        'name',
        'slug',
        'type',
        'bio',
        'image',
        'website',
        'social_links',
        'organization',
        'designation',
        'company',
    ];

    protected $casts = [
        'social_links' => 'array',
    ];

    protected $hidden = [
        'deleted_at',
    ];

    // =========================================================================
    // Relationships
    // =========================================================================

    public function eventParticipants(): HasMany
    {
        return $this->hasMany(EventParticipant::class);
    }

    public function events()
    {
        return $this->belongsToMany(Event::class, 'event_participants')
            ->withPivot(['participant_type_id', 'role_label', 'session_title', 'performance_start', 'performance_end'])
            ->withTimestamps();
    }

    // =========================================================================
    // Scopes
    // =========================================================================

    public function scopeSearch($query, string $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('name', 'LIKE', "%{$term}%")
                ->orWhere('organization', 'LIKE', "%{$term}%")
                ->orWhere('bio', 'LIKE', "%{$term}%");
        });
    }

    // =========================================================================
    // Boot
    // =========================================================================

    public static function boot(): void
    {
        parent::boot();

        static::creating(function (Participant $participant) {
            if (empty($participant->slug)) {
                $participant->slug = self::generateSlug($participant->name);
            }
            if (empty($participant->uuid)) {
                $participant->uuid = Str::uuid();
            }
        });
    }

    public static function generateSlug(string $name): string
    {
        $slug = Str::slug($name);
        $count = static::withoutTrashed()->where('slug', 'like', "{$slug}%")->count();

        return $count ? "{$slug}-{$count}" : $slug;
    }

    // =========================================================================
    // Helpers
    // =========================================================================

    public function getFormattedSocialLinksAttribute(): array
    {
        $links = $this->social_links ?? [];
        $formatted = [];

        foreach ($links as $platform => $url) {
            $formatted[] = [
                'platform' => $platform,
                'url' => $url,
            ];
        }

        return $formatted;
    }
}
