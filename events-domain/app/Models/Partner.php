<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Partner extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'is_verified',
        'company_name',
        'logo_path',
        'website',
        'contact_person',
        'contact_email',
        'contact_phone',
        'city',
        'country',
        'budget_range',
        'preferred_sponsorship_type',
        'about',
        'rating',
        'reviews_count',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'is_verified' => 'boolean',
            'rating' => 'decimal:2',
            'reviews_count' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function profile(): HasOne
    {
        return $this->hasOne(PartnerProfile::class, 'user_id', 'user_id');
    }

    public function services(): HasMany
    {
        return $this->hasMany(PartnerService::class, 'partner_id', 'user_id');
    }

    public function industries(): BelongsToMany
    {
        return $this->belongsToMany(Industry::class, 'partner_industry');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'partner_category');
    }

    public function preferredCities(): HasMany
    {
        return $this->hasMany(PartnerCity::class);
    }
}
