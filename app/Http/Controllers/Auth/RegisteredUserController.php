<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\PlatformSetting;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $this->validateRecaptcha($request);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'mobile' => ['nullable', 'string', 'max:20'],
            'role' => ['required', 'in:organizer,sponsor,partner'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'terms' => ['accepted'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole($request->role);

        $user->markEmailAsVerified();

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
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
