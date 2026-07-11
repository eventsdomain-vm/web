<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sponsor extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'uuid',
        'user_id',
        'name',
        'slug',
        'logo',
        'website',
        'industry',
        'description',
        'social_links',
        'is_verified',
        'sso_provider',
        'sso_client_id',
        'sso_client_secret',
        'sso_enabled',
        'org_type',
        'registration_number',
        'tax_id',
        'headquarters',
        'business_email',
        'business_phone',
        'timezone',
        'default_currency',
        'fiscal_year',
        'org_status',
    ];

    protected function casts(): array
    {
        return [
            'social_links' => 'array',
            'is_verified' => 'boolean',
            'sso_enabled' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function brands(): HasMany
    {
        return $this->hasMany(SponsorBrand::class, 'sponsor_id');
    }

    public function teams(): HasMany
    {
        return $this->hasMany(SponsorTeam::class, 'sponsor_id');
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(SponsorInvoice::class, 'sponsor_id');
    }

    public function integrations(): HasMany
    {
        return $this->hasMany(SponsorIntegration::class, 'sponsor_id');
    }

    public function announcements(): HasMany
    {
        return $this->hasMany(SponsorAnnouncement::class, 'sponsor_id');
    }

    public function auditLogs(): HasMany
    {
        return $this->hasMany(SponsorAuditLog::class, 'sponsor_id');
    }

    public function documents(): HasMany
    {
        return $this->hasMany(SponsorDocument::class, 'sponsor_id');
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(SponsorTask::class, 'sponsor_id');
    }

    public function taxDocuments(): HasMany
    {
        return $this->hasMany(SponsorTaxDocument::class, 'sponsor_id');
    }

    public function paymentTransactions(): HasMany
    {
        return $this->hasMany(SponsorPaymentTransaction::class, 'sponsor_id');
    }

    public function approvalWorkflows(): HasMany
    {
        return $this->hasMany(SponsorApprovalWorkflow::class, 'sponsor_id');
    }

    public function objectives(): HasMany
    {
        return $this->hasMany(SponsorObjective::class, 'sponsor_id');
    }

    public function preferences(): HasMany
    {
        return $this->hasMany(SponsorPreference::class, 'sponsor_id');
    }

    public function budgetAllocations(): HasMany
    {
        return $this->hasMany(SponsorBudgetAllocation::class, 'sponsor_id');
    }

    public function campaigns(): HasMany
    {
        return $this->hasMany(SponsorCampaign::class, 'sponsor_id');
    }

    public function contracts(): HasMany
    {
        return $this->hasMany(SponsorshipContract::class, 'sponsor_id');
    }
}
