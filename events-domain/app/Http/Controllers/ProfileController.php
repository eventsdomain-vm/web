<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Rules\ValidGstin;
use App\Services\Gst\GstVerifier;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Save + verify the user's GSTIN on their profile. Runs the local checksum
     * rule first, then the live verifier; persists verification result. A
     * verified GSTIN drives GST on checkout.
     */
    public function updateGst(Request $request, GstVerifier $verifier): RedirectResponse
    {
        $validated = $request->validate([
            'gst_number' => ['required', 'string', 'size:15', new ValidGstin],
        ]);

        $gstin = strtoupper(trim($validated['gst_number']));

        $profile = $request->user()->profile()->firstOrNew([]);
        // A profile requires a role_type; default from the user's primary role.
        if (! $profile->exists && ! $profile->role_type) {
            $profile->role_type = $request->user()->role_name ?: 'sponsor';
        }

        $result = $verifier->verify($gstin);

        $profile->fill([
            'gst_number' => $gstin,
            'gst_verified' => $result['verified'],
            'gst_verified_at' => $result['verified'] ? now() : null,
            'gst_legal_name' => $result['legal_name'],
        ]);
        $request->user()->profile()->save($profile);

        $status = $result['verified']
            ? 'gst-verified'
            : ($result['format_valid'] ? 'gst-saved-unverified' : 'gst-invalid');

        return Redirect::route('profile.edit')
            ->with('status', $status)
            ->with('gst_reason', $result['reason']);
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
