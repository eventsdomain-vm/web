<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PartnerProfile extends Model
{
    protected $fillable = [
        'user_id', 'company_name', 'company_logo', 'phone', 'address',
        'city', 'state', 'country', 'pincode', 'tax_id',
        'pan_no', 'designation', 'business_type',
        'gst_number', 'gst_verified',
        'gst_legal_name', 'gst_verified_at', 'pan_verified', 'pan_verified_at',
        'website', 'linkedin_url', 'official_email', 'social_media_link',
        'years_of_experience', 'team_size',
        'bio', 'client_references',
        'is_verified', 'verified_at',
    ];

    protected function casts(): array
    {
        return [
            'is_verified' => 'boolean',
            'verified_at' => 'datetime',
            'years_of_experience' => 'integer',
            'team_size' => 'integer',
            'gst_verified' => 'boolean',
            'gst_verified_at' => 'datetime',
            'pan_verified' => 'boolean',
            'pan_verified_at' => 'datetime',
            'client_references' => 'array',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
