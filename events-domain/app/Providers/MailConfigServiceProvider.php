<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\PlatformSetting;
use Illuminate\Support\ServiceProvider;

class MailConfigServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        try {
            $host = PlatformSetting::get('smtp_host');
            $port = PlatformSetting::get('smtp_port');
            $encryption = PlatformSetting::get('smtp_encryption');
            $username = PlatformSetting::get('smtp_username');
            $password = PlatformSetting::get('smtp_password');

            if ($host && $username) {
                config([
                    'mail.default' => 'smtp',
                    'mail.mailers.smtp.host' => $host,
                    'mail.mailers.smtp.port' => (int) ($port ?? 587),
                    'mail.mailers.smtp.encryption' => $encryption,
                    'mail.mailers.smtp.username' => $username,
                    'mail.mailers.smtp.password' => $password,
                ]);
            }
        } catch (\Throwable) {
            // Database may not be ready yet
        }
    }
}
