<?php

declare(strict_types=1);

namespace App\Http\Controllers\Sponsor;

use App\Http\Controllers\Controller;
use App\Models\Sponsor;
use App\Models\SponsorIntegration;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class SecuritySettingsController extends Controller
{
    public function index(): \\Illuminate\\Http\\RedirectResponse
    {
        return redirect()->route('sponsor.dashboard');
    }

    public function storeApiKey(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $sponsor = Sponsor::where('user_id', auth()->id())->firstOrFail();

        $sponsor->integrations()->create([
            'name' => $validated['name'],
            'type' => 'api_key',
            'api_key' => Str::random(40),
            'status' => 'active',
            'provider' => 'internal',
            'credentials' => json_encode(['key_prefix' => substr(Str::random(40), 0, 8)]),
            'metadata' => json_encode(['created_by' => auth()->id()]),
        ]);

        return redirect()->route('sponsor.settings.security')
            ->with('success', 'API key generated successfully.');
    }

    public function revokeApiKey(SponsorIntegration $integration): RedirectResponse
    {
        $sponsor = Sponsor::where('user_id', auth()->id())->firstOrFail();

        if ($integration->sponsor_id !== $sponsor->id) {
            abort(403);
        }

        $integration->update(['status' => 'revoked']);

        return redirect()->route('sponsor.settings.security')
            ->with('success', 'API key revoked.');
    }

    public function updateTwoFactor(Request $request): RedirectResponse
    {
        $request->validate([
            'two_factor_enabled' => 'required|boolean',
        ]);

        $user = auth()->user();
        $user->two_factor_enabled = $request->boolean('two_factor_enabled');
        $user->save();

        return redirect()->route('sponsor.settings.security')
            ->with('success', 'Two-factor authentication '.($user->two_factor_enabled ? 'enabled' : 'disabled').'.');
    }

    public function updateSso(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'sso_provider' => 'nullable|string|in:google,microsoft,okta,azure',
            'sso_client_id' => 'nullable|string|max:500',
            'sso_client_secret' => 'nullable|string|max:500',
            'sso_enabled' => 'boolean',
        ]);

        $sponsor = Sponsor::where('user_id', auth()->id())->firstOrFail();
        $sponsor->update([
            'sso_provider' => $validated['sso_provider'] ?? null,
            'sso_client_id' => $validated['sso_client_id'] ?? null,
            'sso_client_secret' => $validated['sso_client_secret'] ?? null,
            'sso_enabled' => $request->boolean('sso_enabled'),
        ]);

        return redirect()->route('sponsor.settings.security')
            ->with('success', 'SSO configuration updated.');
    }
}
