<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
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
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'mobile' => ['nullable', 'string', 'max:20'],
            'role' => ['required', 'in:organizer,sponsor,partner'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'terms' => ['accepted'],
        ]);

        $mobile = $request->mobile;
        if ($mobile && !str_starts_with($mobile, '+')) {
            $mobile = '+91' . $mobile;
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $mobile,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole($request->role);

        // Send verification email instead of marking verified immediately
        $user->sendEmailVerificationNotification();

        Auth::login($user);

        return redirect(route('verification.notice', absolute: false));
    }
}
