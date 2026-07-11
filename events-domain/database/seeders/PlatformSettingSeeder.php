<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\PlatformSetting;
use Illuminate\Database\Seeder;

class PlatformSettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // General
            ['key' => 'site_name', 'value' => 'EventsDomain', 'type' => 'string', 'group' => 'general'],
            ['key' => 'site_tagline', 'value' => "India's B2B Event Sponsorship Marketplace", 'type' => 'string', 'group' => 'general'],
            ['key' => 'contact_email', 'value' => 'eventsdomain.com@gmail.com', 'type' => 'string', 'group' => 'general'],
            ['key' => 'contact_phone', 'value' => '+91 9725098250', 'type' => 'string', 'group' => 'general'],

            // SEO
            ['key' => 'meta_title', 'value' => 'EventsDomain - B2B Event Sponsorship Marketplace', 'type' => 'string', 'group' => 'seo'],
            ['key' => 'meta_description', 'value' => "India's premier platform connecting event organizers with sponsors and partners", 'type' => 'string', 'group' => 'seo'],
            ['key' => 'google_analytics_id', 'value' => '', 'type' => 'string', 'group' => 'seo'],

            // Email
            ['key' => 'smtp_host', 'value' => '', 'type' => 'string', 'group' => 'email'],
            ['key' => 'smtp_port', 'value' => '587', 'type' => 'integer', 'group' => 'email'],
            ['key' => 'smtp_encryption', 'value' => 'tls', 'type' => 'string', 'group' => 'email'],
            ['key' => 'smtp_username', 'value' => '', 'type' => 'string', 'group' => 'email'],
            ['key' => 'smtp_password', 'value' => '', 'type' => 'string', 'group' => 'email'],

            // Sponsorship
            ['key' => 'service_fee_percentage', 'value' => '5', 'type' => 'float', 'group' => 'sponsorship'],
            ['key' => 'min_sponsorship_amount', 'value' => '10000', 'type' => 'float', 'group' => 'sponsorship'],
            ['key' => 'auto_approve_events', 'value' => '0', 'type' => 'boolean', 'group' => 'sponsorship'],

            // Maintenance
            ['key' => 'maintenance_mode', 'value' => '0', 'type' => 'boolean', 'group' => 'maintenance'],

            // Social Login
            ['key' => 'social_google_client_id', 'value' => '', 'type' => 'string', 'group' => 'social-login'],
            ['key' => 'social_google_client_secret', 'value' => '', 'type' => 'string', 'group' => 'social-login'],
            ['key' => 'social_linkedin_client_id', 'value' => '', 'type' => 'string', 'group' => 'social-login'],
            ['key' => 'social_linkedin_client_secret', 'value' => '', 'type' => 'string', 'group' => 'social-login'],
            ['key' => 'social_facebook_client_id', 'value' => '', 'type' => 'string', 'group' => 'social-login'],
            ['key' => 'social_facebook_client_secret', 'value' => '', 'type' => 'string', 'group' => 'social-login'],
            ['key' => 'social_youtube_api_key', 'value' => '', 'type' => 'string', 'group' => 'social-login'],
        ];

        foreach ($settings as $setting) {
            PlatformSetting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
