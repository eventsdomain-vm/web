<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\OtpVerification;
use App\Models\User;
use App\Services\Sms\SmsService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class OtpService
{
    private const OTP_LENGTH = 6;
    private const OTP_TTL_MINUTES = 10;

    public function __construct(
        private readonly SmsService $smsService,
    ) {}

    public function generate(User $user, string $channel = 'email'): string
    {
        $code = (string) random_int(100000, 999999);

        OtpVerification::create([
            'user_id' => $user->id,
            'otp_code' => $code,
            'channel' => $channel,
            'expires_at' => now()->addMinutes(self::OTP_TTL_MINUTES),
            'attempts' => 0,
        ]);

        return $code;
    }

    public function send(User $user, string $channel = 'email'): bool
    {
        $code = $this->generate($user, $channel);

        return match ($channel) {
            'email' => $this->sendViaEmail($user, $code),
            'sms' => $this->sendViaSms($user, $code),
            'whatsapp' => $this->sendViaWhatsApp($user, $code),
            default => false,
        };
    }

    public function verify(User $user, string $code, ?string $channel = null): bool
    {
        $query = OtpVerification::where('user_id', $user->id)
            ->whereNull('verified_at')
            ->where('expires_at', '>', now());

        if ($channel) {
            $query->where('channel', $channel);
        }

        $otp = $query->latest()->first();

        if (! $otp) {
            return false;
        }

        return $otp->verify($code);
    }

    public function isValid(User $user): bool
    {
        return $user->hasVerifiedEmail();
    }

    public function verifyAndMarkEmail(User $user, string $code, ?string $channel = null): bool
    {
        if (! $this->verify($user, $code, $channel)) {
            return false;
        }

        if (! $user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
        }

        return true;
    }

    private function sendViaEmail(User $user, string $code): bool
    {
        try {
            Mail::send('emails.otp', ['user' => $user, 'code' => $code], function ($message) use ($user) {
                $message->to($user->email)
                    ->subject('Your OTP Code - EventsDomain');
            });

            return true;
        } catch (\Throwable $e) {
            Log::error('Failed to send OTP email', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }

    private function sendViaSms(User $user, string $code): bool
    {
        $mobile = $user->mobile;
        if (! $mobile) {
            Log::warning('Cannot send SMS OTP: user has no mobile number', ['user_id' => $user->id]);

            return false;
        }

        return $this->smsService->send($mobile, "Your EventsDomain verification code is: {$code}. Valid for " . self::OTP_TTL_MINUTES . " minutes.");
    }

    private function sendViaWhatsApp(User $user, string $code): bool
    {
        $mobile = $user->mobile;
        if (! $mobile) {
            Log::warning('Cannot send WhatsApp OTP: user has no mobile number', ['user_id' => $user->id]);

            return false;
        }

        return $this->smsService->sendWhatsApp($mobile, '', 'otp_verification', [$code, (string) self::OTP_TTL_MINUTES]);
    }
}
