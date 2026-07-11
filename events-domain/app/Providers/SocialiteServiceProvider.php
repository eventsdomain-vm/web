<?php

declare(strict_types=1);

namespace App\Providers;

use App\Socialite\OpenIDLinkedInProvider;
use Illuminate\Support\ServiceProvider;

class SocialiteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->app->afterResolving(\Laravel\Socialite\Contracts\Factory::class, function ($manager) {
            $manager->extend('linkedin', function ($app) {
                $config = config('services.linkedin');

                return new OpenIDLinkedInProvider(
                    $app['request'],
                    $config['client_id'],
                    $config['client_secret'],
                    $config['redirect'] ?? null,
                );
            });
        });
    }
}
