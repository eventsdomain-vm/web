<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\PlatformSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Razorpay\Api\Api;

class AdminSettingController extends Controller
{
    public function edit()
    {
        $settings = [
            'general' => PlatformSetting::forGroup('general')->pluck('value', 'key')->toArray(),
            'branding' => PlatformSetting::forGroup('branding')->pluck('value', 'key')->toArray(),
            'seo' => PlatformSetting::forGroup('seo')->pluck('value', 'key')->toArray(),
            'features' => PlatformSetting::forGroup('features')->pluck('value', 'key')->toArray(),
            'performance' => PlatformSetting::forGroup('performance')->pluck('value', 'key')->toArray(),
            'security' => PlatformSetting::forGroup('security')->pluck('value', 'key')->toArray(),
            'notifications' => PlatformSetting::forGroup('notifications')->pluck('value', 'key')->toArray(),
            'backup' => PlatformSetting::forGroup('backup')->pluck('value', 'key')->toArray(),
            'sms' => PlatformSetting::forGroup('sms')->pluck('value', 'key')->toArray(),
            'storage' => PlatformSetting::forGroup('storage')->pluck('value', 'key')->toArray(),
            'integrations' => PlatformSetting::forGroup('integrations')->pluck('value', 'key')->toArray(),
            'social' => PlatformSetting::forGroup('social')->pluck('value', 'key')->toArray(),
            'social-login' => PlatformSetting::forGroup('social-login')->pluck('value', 'key')->toArray(),
            'ai' => PlatformSetting::forGroup('ai')->pluck('value', 'key')->toArray(),
            'email' => PlatformSetting::forGroup('email')->pluck('value', 'key')->toArray(),
            'sponsorship' => PlatformSetting::forGroup('sponsorship')->pluck('value', 'key')->toArray(),
            'maintenance' => PlatformSetting::forGroup('maintenance')->pluck('value', 'key')->toArray(),
        ];

        $paymentGateway = [
            'driver' => config('services.payments.default', 'razorpay'),
            'currency' => config('services.payments.currency', 'INR'),
            'razorpay_key_set' => ! empty(config('services.razorpay.key')),
            'razorpay_secret_set' => ! empty(config('services.razorpay.secret')),
            'razorpay_webhook_secret_set' => ! empty(config('services.razorpay.webhook_secret')),
            'razorpay_sdk_installed' => class_exists(Api::class),
            'razorpay_configured' => ! empty(config('services.razorpay.key'))
                && ! empty(config('services.razorpay.secret'))
                && class_exists(Api::class),
            'webhook_url' => route('webhooks.payments', 'razorpay', absolute: false),
        ];

        $gstApi = [
            'provider' => config('services.gst.provider', 'gstincheck'),
            'key_set' => ! empty(config('services.gst.key')),
            'base_url' => config('services.gst.base_url', 'https://sheet.gstincheck.co.in'),
            'configured' => ! empty(config('services.gst.key')),
        ];

        return view('admin.settings', compact('settings', 'paymentGateway', 'gstApi'));
    }

    public function update(Request $request)
    {
        // Handle checkboxes: when a checkbox is checked, both the hidden input (0)
        // and checkbox (1) submit as an array with multipart/form-data encoding.
        // We need to resolve each to a single value before validation.
        $booleanKeys = [
            'flag_registration', 'flag_event_creation', 'flag_sponsorships',
            'flag_social_login', 'flag_public_profiles', 'flag_event_search',
            'cdn_enabled', 'minify_html', 'lazy_load_images',
            'enforce_https', 'enable_csp',
            'ai_search_enabled', 'ai_content_enabled', 'ai_recommendations_enabled',
            'backup_include_files', 'auto_approve_events', 'maintenance_mode',
        ];
        foreach ($booleanKeys as $key) {
            $val = $request->input($key);
            if (is_array($val)) {
                $request->merge([$key => in_array('1', $val) ? '1' : '0']);
            }
        }

        $validated = $request->validate([
            // General
            'site_name' => 'nullable|string|max:255',
            'site_tagline' => 'nullable|string|max:500',
            'contact_email' => 'nullable|email|max:255',
            'contact_phone' => 'nullable|string|max:20',
            // Branding
            'branding_logo' => 'nullable|image|mimes:png,jpg,jpeg,svg,webp|max:2048',
            'branding_white_logo' => 'nullable|image|mimes:png,jpg,jpeg,svg,webp|max:2048',
            'branding_favicon' => 'nullable|image|mimes:ico,png,svg|max:1024',
            'branding_apple_touch_icon' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:2048',
            'branding_og_image' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:4096',
            'branding_login_bg' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:4096',
            'branding_admin_logo' => 'nullable|image|mimes:png,jpg,jpeg,svg,webp|max:2048',
            // Feature Flags
            'flag_registration' => 'boolean',
            'flag_event_creation' => 'boolean',
            'flag_sponsorships' => 'boolean',
            'flag_social_login' => 'boolean',
            'flag_public_profiles' => 'boolean',
            'flag_event_search' => 'boolean',
            // Notification Templates
            'notify_welcome_subject' => 'nullable|string|max:500',
            'notify_welcome_body' => 'nullable|string',
            'notify_welcome_sms' => 'nullable|string|max:500',
            'notify_event_approved_subject' => 'nullable|string|max:500',
            'notify_event_approved_body' => 'nullable|string',
            'notify_event_approved_sms' => 'nullable|string|max:500',
            'notify_event_rejected_subject' => 'nullable|string|max:500',
            'notify_event_rejected_body' => 'nullable|string',
            'notify_sponsorship_confirmed_subject' => 'nullable|string|max:500',
            'notify_sponsorship_confirmed_body' => 'nullable|string',
            'notify_sponsorship_confirmed_sms' => 'nullable|string|max:500',
            'notify_payment_received_subject' => 'nullable|string|max:500',
            'notify_payment_received_body' => 'nullable|string',
            'notify_account_verified_subject' => 'nullable|string|max:500',
            'notify_account_verified_body' => 'nullable|string',
            // Backup
            'backup_disk' => 'nullable|string|in:local,public,s3',
            'backup_retention_days' => 'nullable|integer|min:1|max:365',
            'backup_schedule' => 'nullable|string|in:daily,weekly,manual',
            'backup_include_files' => 'boolean',
            // SMS / WhatsApp
            'sms_provider' => 'nullable|string|in:twilio,msg91,sms77',
            'twilio_account_sid' => 'nullable|string|max:500',
            'twilio_auth_token' => 'nullable|string|max:500',
            'twilio_from' => 'nullable|string|max:20',
            'msg91_auth_key' => 'nullable|string|max:500',
            'msg91_sender_id' => 'nullable|string|max:10',
            'msg91_route' => 'nullable|string|max:5',
            'whatsapp_access_token' => 'nullable|string|max:500',
            'whatsapp_phone_number_id' => 'nullable|string|max:100',
            // Storage
            'storage_disk' => 'nullable|string|in:local,public,s3',
            // Performance
            'cdn_enabled' => 'boolean',
            'minify_html' => 'boolean',
            'lazy_load_images' => 'boolean',
            // Security
            'enforce_https' => 'boolean',
            'enable_csp' => 'boolean',
            'csp_policy' => 'nullable|string|max:2000',
            // SEO
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            // Integrations
            'google_maps_api_key' => 'nullable|string|max:500',
            'recaptcha_site_key' => 'nullable|string|max:500',
            'recaptcha_secret_key' => 'nullable|string|max:500',
            'facebook_pixel_id' => 'nullable|string|max:100',
            'microsoft_clarity_id' => 'nullable|string|max:100',
            // Social Login / OAuth
            'social_google_client_id' => 'nullable|string|max:500',
            'social_google_client_secret' => 'nullable|string|max:500',
            'social_linkedin_client_id' => 'nullable|string|max:500',
            'social_linkedin_client_secret' => 'nullable|string|max:500',
            'social_facebook_client_id' => 'nullable|string|max:500',
            'social_facebook_client_secret' => 'nullable|string|max:500',
            'social_youtube_api_key' => 'nullable|string|max:500',
            // Social Links
            'facebook_url' => 'nullable|url|max:500',
            'twitter_url' => 'nullable|url|max:500',
            'instagram_url' => 'nullable|url|max:500',
            'linkedin_url' => 'nullable|url|max:500',
            'youtube_url' => 'nullable|url|max:500',
            'whatsapp_url' => 'nullable|url|max:500',
            'telegram_url' => 'nullable|url|max:500',
            // AI
            'ai_default_provider' => 'nullable|string|in:anthropic,openai,gemini,ollama',
            'ai_anthropic_key' => 'nullable|string|max:500',
            'ai_anthropic_model' => 'nullable|string|max:100',
            'ai_openai_key' => 'nullable|string|max:500',
            'ai_openai_model' => 'nullable|string|max:100',
            'ai_gemini_key' => 'nullable|string|max:500',
            'ai_gemini_model' => 'nullable|string|max:100',
            'ai_ollama_endpoint' => 'nullable|string|max:500',
            'ai_ollama_model' => 'nullable|string|max:100',
            'ai_search_enabled' => 'boolean',
            'ai_content_enabled' => 'boolean',
            'ai_recommendations_enabled' => 'boolean',
            'ai_temperature' => 'nullable|numeric|min:0|max:2',
            'ai_max_tokens' => 'nullable|integer|min:1|max:128000',
            'google_analytics_id' => 'nullable|string|max:50',
            // Email
            'smtp_host' => 'nullable|string|max:255',
            'smtp_port' => 'nullable|integer',
            'smtp_encryption' => 'nullable|string|in:tls,ssl',
            'smtp_username' => 'nullable|string|max:255',
            'smtp_password' => 'nullable|string|max:255',
            // Sponsorship
            'service_fee_percentage' => 'nullable|numeric|min:0|max:100',
            'min_sponsorship_amount' => 'nullable|numeric|min:0',
            'auto_approve_events' => 'boolean',
            // Maintenance
            'maintenance_mode' => 'boolean',
        ]);

        // Handle branding file uploads
        $brandingFields = [
            'branding_logo', 'branding_white_logo', 'branding_favicon',
            'branding_apple_touch_icon', 'branding_og_image',
            'branding_login_bg', 'branding_admin_logo',
        ];
        foreach ($brandingFields as $field) {
            if ($request->hasFile($field) && $request->file($field)->isValid()) {
                $path = $request->file($field)->store('branding', 'public');
                PlatformSetting::set($field, $path, 'string', 'branding');
            }
        }

        // Save settings with their groups and types
        $settingsMap = [
            // General
            'site_name' => ['group' => 'general', 'type' => 'string'],
            'site_tagline' => ['group' => 'general', 'type' => 'string'],
            'contact_email' => ['group' => 'general', 'type' => 'string'],
            'contact_phone' => ['group' => 'general', 'type' => 'string'],
            // SEO
            'meta_title' => ['group' => 'seo', 'type' => 'string'],
            'meta_description' => ['group' => 'seo', 'type' => 'string'],
            // Social Links
            // Social Login / OAuth
            'social_google_client_id' => ['group' => 'social-login', 'type' => 'string'],
            'social_google_client_secret' => ['group' => 'social-login', 'type' => 'string'],
            'social_linkedin_client_id' => ['group' => 'social-login', 'type' => 'string'],
            'social_linkedin_client_secret' => ['group' => 'social-login', 'type' => 'string'],
            'social_facebook_client_id' => ['group' => 'social-login', 'type' => 'string'],
            'social_facebook_client_secret' => ['group' => 'social-login', 'type' => 'string'],
            'social_youtube_api_key' => ['group' => 'social-login', 'type' => 'string'],
            // Integrations
            'google_maps_api_key' => ['group' => 'integrations', 'type' => 'string'],
            'recaptcha_site_key' => ['group' => 'integrations', 'type' => 'string'],
            'recaptcha_secret_key' => ['group' => 'integrations', 'type' => 'string'],
            'facebook_pixel_id' => ['group' => 'integrations', 'type' => 'string'],
            'microsoft_clarity_id' => ['group' => 'integrations', 'type' => 'string'],
            'facebook_url' => ['group' => 'social', 'type' => 'string'],
            'twitter_url' => ['group' => 'social', 'type' => 'string'],
            'instagram_url' => ['group' => 'social', 'type' => 'string'],
            'linkedin_url' => ['group' => 'social', 'type' => 'string'],
            'youtube_url' => ['group' => 'social', 'type' => 'string'],
            'whatsapp_url' => ['group' => 'social', 'type' => 'string'],
            'telegram_url' => ['group' => 'social', 'type' => 'string'],
            // AI
            'ai_default_provider' => ['group' => 'ai', 'type' => 'string'],
            'ai_anthropic_key' => ['group' => 'ai', 'type' => 'string'],
            'ai_anthropic_model' => ['group' => 'ai', 'type' => 'string'],
            'ai_openai_key' => ['group' => 'ai', 'type' => 'string'],
            'ai_openai_model' => ['group' => 'ai', 'type' => 'string'],
            'ai_gemini_key' => ['group' => 'ai', 'type' => 'string'],
            'ai_gemini_model' => ['group' => 'ai', 'type' => 'string'],
            'ai_ollama_endpoint' => ['group' => 'ai', 'type' => 'string'],
            'ai_ollama_model' => ['group' => 'ai', 'type' => 'string'],
            'ai_search_enabled' => ['group' => 'ai', 'type' => 'boolean'],
            'ai_content_enabled' => ['group' => 'ai', 'type' => 'boolean'],
            'ai_recommendations_enabled' => ['group' => 'ai', 'type' => 'boolean'],
            'ai_temperature' => ['group' => 'ai', 'type' => 'float'],
            'ai_max_tokens' => ['group' => 'ai', 'type' => 'integer'],
            // Feature Flags
            'flag_registration' => ['group' => 'features', 'type' => 'boolean'],
            'flag_event_creation' => ['group' => 'features', 'type' => 'boolean'],
            'flag_sponsorships' => ['group' => 'features', 'type' => 'boolean'],
            'flag_social_login' => ['group' => 'features', 'type' => 'boolean'],
            'flag_public_profiles' => ['group' => 'features', 'type' => 'boolean'],
            'flag_event_search' => ['group' => 'features', 'type' => 'boolean'],
            // Notification Templates
            'notify_welcome_subject' => ['group' => 'notifications', 'type' => 'string'],
            'notify_welcome_body' => ['group' => 'notifications', 'type' => 'string'],
            'notify_welcome_sms' => ['group' => 'notifications', 'type' => 'string'],
            'notify_event_approved_subject' => ['group' => 'notifications', 'type' => 'string'],
            'notify_event_approved_body' => ['group' => 'notifications', 'type' => 'string'],
            'notify_event_approved_sms' => ['group' => 'notifications', 'type' => 'string'],
            'notify_event_rejected_subject' => ['group' => 'notifications', 'type' => 'string'],
            'notify_event_rejected_body' => ['group' => 'notifications', 'type' => 'string'],
            'notify_sponsorship_confirmed_subject' => ['group' => 'notifications', 'type' => 'string'],
            'notify_sponsorship_confirmed_body' => ['group' => 'notifications', 'type' => 'string'],
            'notify_sponsorship_confirmed_sms' => ['group' => 'notifications', 'type' => 'string'],
            'notify_payment_received_subject' => ['group' => 'notifications', 'type' => 'string'],
            'notify_payment_received_body' => ['group' => 'notifications', 'type' => 'string'],
            'notify_account_verified_subject' => ['group' => 'notifications', 'type' => 'string'],
            'notify_account_verified_body' => ['group' => 'notifications', 'type' => 'string'],
            // Backup
            'backup_disk' => ['group' => 'backup', 'type' => 'string'],
            'backup_retention_days' => ['group' => 'backup', 'type' => 'integer'],
            'backup_schedule' => ['group' => 'backup', 'type' => 'string'],
            'backup_include_files' => ['group' => 'backup', 'type' => 'boolean'],
            // SMS / WhatsApp
            'sms_provider' => ['group' => 'sms', 'type' => 'string'],
            'twilio_account_sid' => ['group' => 'sms', 'type' => 'string'],
            'twilio_auth_token' => ['group' => 'sms', 'type' => 'string'],
            'twilio_from' => ['group' => 'sms', 'type' => 'string'],
            'msg91_auth_key' => ['group' => 'sms', 'type' => 'string'],
            'msg91_sender_id' => ['group' => 'sms', 'type' => 'string'],
            'msg91_route' => ['group' => 'sms', 'type' => 'string'],
            'whatsapp_access_token' => ['group' => 'sms', 'type' => 'string'],
            'whatsapp_phone_number_id' => ['group' => 'sms', 'type' => 'string'],
            // Storage
            'storage_disk' => ['group' => 'storage', 'type' => 'string'],
            // Performance
            'cdn_enabled' => ['group' => 'performance', 'type' => 'boolean'],
            'minify_html' => ['group' => 'performance', 'type' => 'boolean'],
            'lazy_load_images' => ['group' => 'performance', 'type' => 'boolean'],
            // Security
            'enforce_https' => ['group' => 'security', 'type' => 'boolean'],
            'enable_csp' => ['group' => 'security', 'type' => 'boolean'],
            'csp_policy' => ['group' => 'security', 'type' => 'string'],
            'google_analytics_id' => ['group' => 'seo', 'type' => 'string'],
            // Email
            'smtp_host' => ['group' => 'email', 'type' => 'string'],
            'smtp_port' => ['group' => 'email', 'type' => 'integer'],
            'smtp_encryption' => ['group' => 'email', 'type' => 'string'],
            'smtp_username' => ['group' => 'email', 'type' => 'string'],
            'smtp_password' => ['group' => 'email', 'type' => 'string'],
            // Sponsorship
            'service_fee_percentage' => ['group' => 'sponsorship', 'type' => 'float'],
            'min_sponsorship_amount' => ['group' => 'sponsorship', 'type' => 'float'],
            'auto_approve_events' => ['group' => 'sponsorship', 'type' => 'boolean'],
            // Maintenance
            'maintenance_mode' => ['group' => 'maintenance', 'type' => 'boolean'],
        ];

        foreach ($validated as $key => $value) {
            if (isset($settingsMap[$key])) {
                $meta = $settingsMap[$key];
                PlatformSetting::set($key, $value, $meta['type'], $meta['group']);
            }
        }

        // Log the activity
        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'settings_updated',
            'description' => 'Platform settings updated',
            'properties' => ['keys' => array_keys($validated)],
            'ip_address' => $request->ip(),
        ]);

        return redirect()->route('admin.settings')
            ->with('success', 'Settings updated successfully!');
    }

    public function clearCache(Request $request)
    {
        $action = $request->input('action', 'all');

        $results = [];

        if ($action === 'all' || $action === 'config') {
            Artisan::call('config:cache');
            $results[] = 'Configuration cache cleared and re-cached.';
        }
        if ($action === 'all' || $action === 'route') {
            Artisan::call('route:cache');
            $results[] = 'Route cache cleared and re-cached.';
        }
        if ($action === 'all' || $action === 'view') {
            Artisan::call('view:clear');
            $results[] = 'View cache cleared.';
        }
        if ($action === 'all' || $action === 'event') {
            Artisan::call('event:cache');
            $results[] = 'Event cache cleared and re-cached.';
        }
        if ($action === 'all' || $action === 'optimize') {
            Artisan::call('optimize:clear');
            $results[] = 'All optimizations cleared.';
        }

        ActivityLog::log('cache_cleared', 'Cleared cache: '.implode(', ', $results));

        return redirect()->route('admin.settings')
            ->with('success', implode(' ', $results));
    }

    public function runBackup(): RedirectResponse
    {
        $exitCode = Artisan::call('backup:run');

        if ($exitCode === 0) {
            return redirect()->route('admin.settings')
                ->with('success', Artisan::output());
        }

        return redirect()->route('admin.settings')
            ->with('error', 'Backup failed. Check server logs for details.');
    }
}
