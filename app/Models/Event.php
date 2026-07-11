<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Event extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, SoftDeletes;

    protected $fillable = [
        'organizer_id',
        'title',
        'slug',
        'tagline',
        'description',
        'category_id',
        'subcategory_id',
        'event_type',
        'visibility',
        'approval_status',
        'status',
        'rejection_reason',
        'timezone',
        'currency',
        'budget_min',
        'budget_max',
        'minimum_sponsorship',
        'maximum_sponsorship',
        'sponsorship_type',
        'expected_audience',
        'audience_description',
        'registration_deadline',
        'registration_url',
        'website_url',
        'video_url',
        'plan',
        'logo',
        'cover_image',
        'banner_image',
        'previous_edition_stats',
        'tags',
        'is_featured',
        'is_published',
        'published_at',
        'views_count',
        'start_date',
        'end_date',
        'next_occurrence_at',
        'venue',
        'city',
        'state',
        'country',
        'primary_latitude',
        'primary_longitude',
        'has_celebrity',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'next_occurrence_at' => 'datetime',
        'registration_deadline' => 'date',
        'expected_audience' => 'integer',
        'budget_min' => 'decimal:2',
        'budget_max' => 'decimal:2',
        'minimum_sponsorship' => 'decimal:2',
        'maximum_sponsorship' => 'decimal:2',
        'primary_latitude' => 'decimal:7',
        'primary_longitude' => 'decimal:7',
        'is_featured' => 'boolean',
        'is_published' => 'boolean',
        'published_at' => 'datetime',
        'views_count' => 'integer',
        'previous_edition_stats' => 'array',
        'tags' => 'array',
    ];

    protected $hidden = [
        'deleted_at',
    ];

    // =========================================================================
    // Relationships
    // =========================================================================

    public function organizer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'subcategory_id');
    }

    public function dates(): HasMany
    {
        return $this->hasMany(EventDate::class);
    }

    public function venues(): HasMany
    {
        return $this->hasMany(EventVenue::class);
    }

    public function stages(): HasMany
    {
        return $this->hasMany(EventStage::class);
    }

    public function participants(): HasMany
    {
        return $this->hasMany(EventParticipant::class);
    }

    public function gallery(): HasMany
    {
        return $this->hasMany(EventGallery::class, 'event_id');
    }

    public function audience(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(EventAudience::class);
    }

    public function sponsorshipLevels(): HasMany
    {
        return $this->hasMany(EventSponsorshipLevel::class);
    }

    public function eventMedia(): HasMany
    {
        return $this->hasMany(EventMedia::class);
    }

    public function stalls(): HasMany
    {
        return $this->hasMany(EventStall::class);
    }

    public function fnbOptions(): HasMany
    {
        return $this->hasMany(EventFnbOption::class);
    }

    public function adSpaces(): HasMany
    {
        return $this->hasMany(EventAdSpace::class);
    }

    public function schedule(): HasMany
    {
        return $this->hasMany(EventSchedule::class);
    }

    public function team(): HasMany
    {
        return $this->hasMany(EventTeam::class);
    }

    public function packages(): HasMany
    {
        return $this->hasMany(SponsorshipPackage::class);
    }

    public function sponsorshipRequests(): HasMany
    {
        return $this->hasMany(SponsorshipRequest::class);
    }

    public function posts(): HasMany
    {
        return $this->hasMany(EventPost::class);
    }

    public function partnerRequests(): HasMany
    {
        return $this->hasMany(PartnerRequest::class);
    }

    public function partnerBids(): HasMany
    {
        return $this->hasMany(PartnerBid::class);
    }

    // =========================================================================
    // Marketplace — Sponsor
    // =========================================================================

    public function sponsorProposals(): HasMany
    {
        return $this->hasMany(SponsorProposal::class);
    }

    public function sponsorSavedEvents(): HasMany
    {
        return $this->hasMany(SponsorSavedEvent::class);
    }

    public function sponsorCampaigns(): HasMany
    {
        return $this->hasMany(SponsorCampaign::class);
    }

    // =========================================================================

    public function conversations(): HasMany
    {
        return $this->hasMany(Conversation::class);
    }

    // =========================================================================
    // Scopes
    // =========================================================================

    public function scopePublished($query)
    {
        return $query->where('is_published', true)
            ->where('approval_status', 'approved');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeUpcoming($query)
    {
        return $query->where('start_date', '>=', now());
    }

    public function scopePast($query)
    {
        return $query->where('start_date', '<', now());
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    // =========================================================================
    // Helpers
    // =========================================================================

    public static function boot(): void
    {
        parent::boot();

        static::creating(function ($event) {
            if (empty($event->slug)) {
                $event->slug = self::generateSlug($event->title);
            }
        });
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('logo')
            ->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp'])
            ->withCustomProperties(['usage' => 'logo']);

        $this->addMediaCollection('cover_image')
            ->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp'])
            ->withCustomProperties(['usage' => 'cover']);

        $this->addMediaCollection('banner_image')
            ->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp'])
            ->withCustomProperties(['usage' => 'banner']);

        $this->addMediaCollection('gallery')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/webp'])
            ->withCustomProperties(['usage' => 'gallery']);
    }

    public static function generateSlug(string $title): string
    {
        $slug = Str::slug($title);
        $count = static::where('slug', 'like', "{$slug}%")->count();

        return $count ? "{$slug}-{$count}" : $slug;
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'draft' => 'Draft',
            'pending' => 'Pending Approval',
            'approved' => 'Approved',
            'rejected' => 'Rejected',
            'live' => 'Live',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled',
            default => ucfirst($this->status),
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'draft' => 'gray',
            'pending' => 'yellow',
            'approved' => 'green',
            'rejected' => 'red',
            'live' => 'blue',
            'completed' => 'purple',
            'cancelled' => 'red',
            default => 'gray',
        };
    }

    public function isDraft(): bool
    {
        return $this->status === 'draft';
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isPublished(): bool
    {
        return $this->is_published && $this->approval_status === 'approved';
    }

    public function isUpcoming(): bool
    {
        return $this->start_date && $this->start_date->isFuture();
    }

    public function isPast(): bool
    {
        return $this->start_date && $this->start_date->isPast();
    }

    public function incrementViews(): void
    {
        $this->increment('views_count');
    }

    public function getCoverImageUrlAttribute(): ?string
    {
        $media = $this->getFirstMedia('cover_image');
        if ($media) {
            return $media->getUrl();
        }

        // Fallback for legacy data - only return URL if file exists on disk
        if (empty($this->cover_image)) {
            return null;
        }
        if (str_starts_with($this->cover_image, 'http://') || str_starts_with($this->cover_image, 'https://')) {
            return $this->cover_image;
        }

        try {
            $disk = Storage::disk('public');
            if ($disk->exists($this->cover_image)) {
                return $disk->url($this->cover_image);
            }
        } catch (\Throwable) {}

        return null;
    }

    public function getLogoUrlAttribute(): ?string
    {
        if (empty($this->logo)) {
            return null;
        }
        if (str_starts_with($this->logo, 'http://') || str_starts_with($this->logo, 'https://')) {
            return $this->logo;
        }
        try {
            $disk = Storage::disk('public');
            if ($disk->exists($this->logo)) {
                return $disk->url($this->logo);
            }
        } catch (\Throwable) {}
        return null;
    }

    public function getLocationDisplayAttribute(): ?string
    {
        if ($this->event_type === 'virtual') {
            return 'Virtual Event';
        }

        $parts = array_filter([$this->city, $this->state, $this->country]);

        return $parts ? implode(', ', $parts) : null;
    }
}
