<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasApiTokens, HasFactory, HasRoles, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'mobile',
        'avatar',
        'phone',
        'provider',
        'provider_id',
        'provider_token',
        'provider_refresh_token',
        'is_verified',
        'two_factor_enabled',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'provider_token',
        'provider_refresh_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'mobile_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_verified' => 'boolean',
            'two_factor_enabled' => 'boolean',
        ];
    }

    // =========================================================================
    // Relationships
    // =========================================================================

    /**
     * Get the user's profile.
     */
    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class);
    }

    /**
     * Get the user's OTP verifications.
     */
    public function otpVerifications(): HasMany
    {
        return $this->hasMany(OtpVerification::class);
    }

    /**
     * Get events organized by this user.
     */
    public function organizedEvents(): HasMany
    {
        return $this->hasMany(Event::class, 'organizer_id');
    }

    /**
     * Get events this user is a team member of.
     */
    public function teamEvents(): HasMany
    {
        return $this->hasMany(EventTeam::class);
    }

    /**
     * Get sponsorship requests sent by this user (as sponsor).
     */
    public function sponsorshipRequests(): HasMany
    {
        return $this->hasMany(SponsorshipRequest::class, 'sponsor_id');
    }

    /**
     * Get partner services offered by this user.
     */
    public function partnerServices(): HasMany
    {
        return $this->hasMany(PartnerService::class, 'partner_id');
    }

    /**
     * Get partner bids made by this user.
     */
    public function partnerBids(): HasMany
    {
        return $this->hasMany(PartnerBid::class, 'partner_id');
    }

    /**
     * Get social accounts linked to this user.
     */
    public function socialAccounts(): HasMany
    {
        return $this->hasMany(SocialAccount::class);
    }

    /**
     * Get conversations this user participates in.
     */
    public function conversations(): HasMany
    {
        return $this->hasMany(ConversationParticipant::class);
    }

    /**
     * Get messages sent by this user.
     */
    public function sentMessages(): HasMany
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    /**
     * Get activity logs for this user.
     */
    public function activityLogs(): HasMany
    {
        return $this->hasMany(ActivityLog::class);
    }

    // =========================================================================
    // Marketplace — Sponsor
    // =========================================================================

    public function sponsorProposals(): HasMany
    {
        return $this->hasMany(SponsorProposal::class, 'sponsor_id');
    }

    public function sponsorBudgets(): HasMany
    {
        return $this->hasMany(SponsorBudget::class, 'sponsor_id');
    }

    public function sponsorCampaigns(): HasMany
    {
        return $this->hasMany(SponsorCampaign::class, 'sponsor_id');
    }

    public function sponsorSavedEvents(): HasMany
    {
        return $this->hasMany(SponsorSavedEvent::class, 'sponsor_id');
    }

    public function sponsorComparisons(): HasMany
    {
        return $this->hasMany(SponsorComparison::class, 'sponsor_id');
    }

    public function sponsorTeamMembers(): HasMany
    {
        return $this->hasMany(SponsorTeamMember::class, 'sponsor_id');
    }

    public function sponsorInternalNotes(): HasMany
    {
        return $this->hasMany(SponsorInternalNote::class, 'sponsor_id');
    }

    // =========================================================================
    // Marketplace — Partner
    // =========================================================================

    public function partnerAvailability(): HasMany
    {
        return $this->hasMany(PartnerAvailability::class, 'partner_id');
    }

    public function partnerPortfolioItems(): HasMany
    {
        return $this->hasMany(PartnerPortfolioItem::class, 'partner_id');
    }

    public function partnerPayouts(): HasMany
    {
        return $this->hasMany(PartnerPayout::class, 'partner_id');
    }

    // =========================================================================
    // Helpers
    // =========================================================================

    /**
     * Check if user has a specific role.
     */
    public function hasRole($roles, ?string $guard = null): bool
    {
        if (is_string($roles)) {
            return $this->roles->contains('name', $roles);
        }

        if (is_array($roles)) {
            foreach ($roles as $role) {
                if (is_string($role)) {
                    if ($this->roles->contains('name', $role)) {
                        return true;
                    }
                } elseif (is_array($role)) {
                    if ($this->hasRole($role, $guard)) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    /**
     * Get the user's primary role name.
     */
    public function getRoleNameAttribute(): ?string
    {
        return $this->roles->first()?->name;
    }

    /**
     * Get user's avatar URL or default.
     */
    public function getAvatarUrlAttribute(): string
    {
        return $this->avatar ?? asset('images/default-avatar.png');
    }

    /**
     * Check if user's profile is complete.
     */
    public function isProfileComplete(): bool
    {
        if (! $this->profile) {
            return false;
        }

        $requiredFields = ['company_name', 'description', 'location'];

        foreach ($requiredFields as $field) {
            if (empty($this->profile->$field)) {
                return false;
            }
        }

        return true;
    }
}
