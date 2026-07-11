<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\Event;
use App\Models\EventDate;
use App\Models\EventVenue;
use App\Models\SponsorProposal;
use App\Observers\EventDateObserver;
use App\Observers\EventVenueObserver;
use App\Observers\SponsorProposalObserver;
use App\Policies\EventPolicy;
use App\Services\Payments\PaymentManager;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(PaymentManager::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        EventDate::observe(EventDateObserver::class);
        EventVenue::observe(EventVenueObserver::class);
        SponsorProposal::observe(SponsorProposalObserver::class);

        // Explicitly register policy (auto-discovery backup)
        Gate::policy(Event::class, EventPolicy::class);
    }
}
