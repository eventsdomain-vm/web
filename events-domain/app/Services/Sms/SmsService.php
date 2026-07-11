<?php

declare(strict_types=1);

namespace App\Services\Sms;

use App\Models\PlatformSetting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SmsService
{
    private string $provider;

    private array $config;

    public function __construct()
    {
        $this->provider = PlatformSetting::get('sms_provider', config('services.sms.default', 'twilio'));
        $this->config = config('services.sms.'.$this->provider, []);
    }

    public function send(string $to, string $message, ?string $provider = null): bool
    {
        $provider = $provider ?? $this->provider;

        return match ($provider) {
            'twilio' => $this->sendViaTwilio($to, $message),
            'msg91' => $this->sendViaMsg91($to, $message),
            'sms77' => $this->sendViaSms77($to, $message),
            default => false,
        };
    }

    public function sendWhatsApp(string $to, string $message, ?string $template = null, array $params = []): bool
    {
        $accessToken = PlatformSetting::get('whatsapp_access_token', $this->config['access_token'] ?? '');
        $phoneNumberId = PlatformSetting::get('whatsapp_phone_number_id', $this->config['phone_number_id'] ?? '');

        if (empty($accessToken) || empty($phoneNumberId)) {
            Log::warning('WhatsApp not configured');

            return false;
        }

        $payload = [
            'messaging_product' => 'whatsapp',
            'to' => $to,
        ];

        if ($template) {
            $payload['type'] = 'template';
            $payload['template']['name'] = $template;
            $payload['template']['language']['code'] = 'en';
            if (! empty($params)) {
                $payload['template']['components'] = [
                    ['type' => 'body', 'parameters' => array_map(fn ($p) => ['type' => 'text', 'text' => $p], $params)],
                ];
            }
        } else {
            $payload['type'] = 'text';
            $payload['text']['body'] = $message;
        }

        $response = Http::withToken($accessToken)
            ->post("https://graph.facebook.com/v21.0/{$phoneNumberId}/messages", $payload);

        if (! $response->successful()) {
            Log::error('WhatsApp send failed', ['response' => $response->body()]);

            return false;
        }

        return true;
    }

    private function sendViaTwilio(string $to, string $message): bool
    {
        $accountSid = PlatformSetting::get('twilio_account_sid', $this->config['account_sid'] ?? '');
        $authToken = PlatformSetting::get('twilio_auth_token', $this->config['auth_token'] ?? '');
        $from = PlatformSetting::get('twilio_from', $this->config['from'] ?? '');

        if (empty($accountSid) || empty($authToken) || empty($from)) {
            Log::warning('Twilio not configured');

            return false;
        }

        $response = Http::withBasicAuth($accountSid, $authToken)
            ->asForm()
            ->post("https://api.twilio.com/2010-04-01/Accounts/{$accountSid}/Messages.json", [
                'From' => $from,
                'To' => $to,
                'Body' => $message,
            ]);

        if (! $response->successful()) {
            Log::error('Twilio send failed', ['response' => $response->body()]);

            return false;
        }

        return true;
    }

    private function sendViaMsg91(string $to, string $message): bool
    {
        $authKey = PlatformSetting::get('msg91_auth_key', $this->config['auth_key'] ?? '');
        $senderId = PlatformSetting::get('msg91_sender_id', $this->config['sender_id'] ?? 'EVENTSD');
        $route = PlatformSetting::get('msg91_route', $this->config['route'] ?? '4');

        if (empty($authKey)) {
            Log::warning('MSG91 not configured');

            return false;
        }

        $response = Http::withHeaders([
            'authkey' => $authKey,
            'Content-Type' => 'application/json',
        ])->post('https://api.msg91.com/api/v5/flow/', [
            'sender' => $senderId,
            'mobiles' => $to,
            'message' => $message,
            'route' => $route,
        ]);

        if (! $response->successful()) {
            Log::error('MSG91 send failed', ['response' => $response->body()]);

            return false;
        }

        return true;
    }

    private function sendViaSms77(string $to, string $message): bool
    {
        $apiKey = PlatformSetting::get('sms77_api_key', $this->config['api_key'] ?? '');
        $from = PlatformSetting::get('sms77_from', $this->config['from'] ?? '');

        if (empty($apiKey)) {
            Log::warning('SMS77 not configured');

            return false;
        }

        $payload = [
            'p' => $apiKey,
            'to' => $to,
            'text' => $message,
        ];
        if (! empty($from)) {
            $payload['from'] = $from;
        }

        $response = Http::asForm()->post('https://gateway.sms77.io/api/sms', $payload);

        if (! $response->successful()) {
            Log::error('SMS77 send failed', ['response' => $response->body()]);

            return false;
        }

        return true;
    }
}
