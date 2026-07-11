<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Partner extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'company_name', 'logo_path', 'website',
        'contact_person', 'contact_email', 'contact_phone',
        'city', 'country', 'budget_range',
        'preferred_sponsorship_type', 'about', 'status',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function industries(): BelongsToMany
    {
        return $this->belongsToMany(Industry::class, 'partner_industry');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'partner_category');
    }

    // Simple string-based city preferences (no lookup table needed for this one)
    public function preferredCities()
    {
        return $this->hasMany(PartnerCity::class);
    }

    /**
     * Sponsor-discovery: find events that match this partner's stated interests.
     * Chain onto Event::query() from the controller.
     */
    public function scopeMatchingEventsQuery(Event $eventQuery = null)
    {
        // usage: Event::query()->matchingPartner($partner)->get();
    }
}
