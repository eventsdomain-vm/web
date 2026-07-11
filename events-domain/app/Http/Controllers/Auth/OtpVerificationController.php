<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\OtpService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OtpVerificationController extends Controller
{
    public function __construct(
        private readonly OtpService $otpService,
    ) {}

    public function showVerifyForm(): View
    {
        return view('auth.verify-otp');
    }

    public function send(Request $request): RedirectResponse
    {
        $request->validate([
            'channel' => 'required|in:email,sms,whatsapp',
        ]);

        $user = $request->user();

        if ($user->hasVerifiedEmail()) {
            return redirect()->intended(route('dashboard'));
        }

        $sent = $this->otpService->send($user, $request->channel);

        if (! $sent) {
            return back()->withErrors([
                'otp' => 'Failed to send OTP. Please try again later.',
            ]);
        }

        return back()->with('status', 'otp-sent');
    }

    public function verify(Request $request): RedirectResponse
    {
        $request->validate([
            'code' => 'required|string|size:6',
        ]);

        $user = $request->user();

        if ($user->hasVerifiedEmail()) {
            return redirect()->intended(route('dashboard'));
        }

        $verified = $this->otpService->verifyAndMarkEmail($user, $request->code);

        if (! $verified) {
            return back()->withErrors([
                'code' => 'Invalid or expired OTP code. Please try again.',
            ]);
        }

        return redirect()->intended(route('dashboard') . '?verified=1');
    }
}
