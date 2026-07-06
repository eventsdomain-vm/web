<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\PlatformSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $this->validateRecaptcha($request);

        $request->authenticate();

        $request->session()->regenerate();

        if (! $request->user()->hasVerifiedEmail()) {
            $request->user()->markEmailAsVerified();
        }

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    private function validateRecaptcha(Request $request): void
    {
        $secretKey = PlatformSetting::get('recaptcha_secret_key');
        if (! $secretKey) {
            return;
        }

        $token = $request->input('g-recaptcha-response');
        if (! $token) {
            throw ValidationException::withMessages(['g-recaptcha-response' => 'reCAPTCHA verification is required.']);
        }

        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => $secretKey,
            'response' => $token,
            'remoteip' => $request->ip(),
        ]);

        $body = $response->json();

        if (! ($body['success'] ?? false)) {
            throw ValidationException::withMessages(['g-recaptcha-response' => 'reCAPTCHA verification failed. Please try again.']);
        }
    }
}
