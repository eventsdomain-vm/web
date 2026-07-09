<?php

declare(strict_types=1);

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use App\Models\PlatformSetting;
use App\Models\SocialAccount;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Laravel\Socialite\Facades\Socialite;

class SocialAccountController extends Controller
{
    private const SUPPORTED_PROVIDERS = ['facebook', 'linkedin', 'google'];

    private const PROVIDER_MAP = [
        'facebook' => ['id' => 'social_facebook_client_id', 'secret' => 'social_facebook_client_secret'],
        'linkedin' => ['id' => 'social_linkedin_client_id', 'secret' => 'social_linkedin_client_secret'],
        'google' => ['id' => 'social_google_client_id', 'secret' => 'social_google_client_secret'],
    ];

    private function loadSocialConfig(): void
    {
        $settings = PlatformSetting::forGroup('social-login')
            ->pluck('value', 'key')
            ->toArray();

        $user = auth()->user();
        $routePrefix = $user?->hasRole('partner') ? 'partner.social.callback' : 'organizer.social.callback';

        foreach (self::PROVIDER_MAP as $provider => $keys) {
            $clientId = $settings[$keys['id']] ?? config("services.{$provider}.client_id");
            $clientSecret = $settings[$keys['secret']] ?? config("services.{$provider}.client_secret");

            config([
                "services.{$provider}" => [
                    'client_id' => $clientId,
                    'client_secret' => $clientSecret,
                    'redirect' => route($routePrefix, $provider),
                ],
            ]);
        }
    }

    public function index(Request $request): View
    {
        $user = $request->user();
        $accounts = SocialAccount::where('user_id', $user->id)->get()->keyBy('provider');

        $rp = $user->hasRole('partner') ? 'partner' : 'organizer';

        return view($rp . '.social.index', [
            'accounts' => $accounts,
            'providers' => self::SUPPORTED_PROVIDERS,
            'rp' => $rp,
        ]);
    }

    public function connect(string $provider): RedirectResponse
    {
        abort_unless(in_array($provider, self::SUPPORTED_PROVIDERS), 404);

        $this->loadSocialConfig();

        $scopes = $this->getScopes($provider);

        $driver = Socialite::driver($provider);

        if (! empty($scopes)) {
            $driver->scopes($scopes);
        }

        return $driver->redirect();
    }

    public function callback(string $provider): RedirectResponse
    {
        abort_unless(in_array($provider, self::SUPPORTED_PROVIDERS), 404);

        $this->loadSocialConfig();

        try {
            // Check for error from LinkedIn
            if ($request = request()->query('error')) {
                $desc = request()->query('error_description', 'Unknown error');
                Log::error("LinkedIn OAuth error: {$request} - {$desc}");
                $rp = auth()->user()->hasRole('partner') ? 'partner' : 'organizer';
                return redirect()->route($rp.'.social.index')
                    ->with('error', 'LinkedIn denied access: ' . $desc);
            }

            $socialUser = Socialite::driver($provider)->user();

            $user = auth()->user();

            $providerId = $socialUser->getId();
            $name = $socialUser->getName() ?? $socialUser->getNickname() ?? $provider.' user';
            $email = $socialUser->getEmail();

            // For LinkedIn OpenID Connect, fallback to extra details if needed
            if ($provider === 'linkedin' && empty($email)) {
                $email = $socialUser->getRaw()['email'] ?? null;
            }
            if ($provider === 'linkedin' && $name === $provider.' user') {
                $raw = $socialUser->getRaw();
                $name = trim(($raw['given_name'] ?? '').' '.($raw['family_name'] ?? '')) ?: $name;
            }

            SocialAccount::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'provider' => $provider,
                    'provider_id' => $providerId,
                ],
                [
                    'name' => $name,
                    'email' => $email,
                    'avatar' => $socialUser->getAvatar(),
                    'access_token' => $socialUser->token,
                    'refresh_token' => $socialUser->refreshToken,
                    'token_expires_at' => $socialUser->expiresIn
                        ? now()->addSeconds($socialUser->expiresIn)
                        : null,
                ]
            );

            $rp = auth()->user()->hasRole('partner') ? 'partner' : 'organizer';

            return redirect()->route($rp.'.social.index')
                ->with('success', ucfirst($provider).' account connected successfully.');
        } catch (\Exception $e) {
            Log::error("Social connect failed for provider [{$provider}]: ".$e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            $rp = auth()->user()->hasRole('partner') ? 'partner' : 'organizer';

            return redirect()->route($rp.'.social.index')
                ->with('error', 'Failed to connect '.ucfirst($provider).' account. Please try again.');
        }
    }

    public function disconnect(Request $request, string $provider): RedirectResponse
    {
        abort_unless(in_array($provider, self::SUPPORTED_PROVIDERS), 404);

        SocialAccount::where('user_id', $request->user()->id)
            ->where('provider', $provider)
            ->delete();

        $rp = $request->user()->hasRole('partner') ? 'partner' : 'organizer';

        return redirect()->route($rp.'.social.index')
            ->with('success', ucfirst($provider).' account disconnected.');
    }

    public function status(Request $request): JsonResponse
    {
        $accounts = SocialAccount::where('user_id', $request->user()->id)
            ->get()
            ->map(fn (SocialAccount $account) => [
                'provider' => $account->provider,
                'name' => $account->name,
                'email' => $account->email,
                'connected' => true,
                'token_expires_at' => $account->token_expires_at?->toIso8601String(),
            ]);

        return response()->json(['accounts' => $accounts]);
    }

    private function getScopes(string $provider): array
    {
        return match ($provider) {
            'facebook' => [
                'email',
                'pages_show_list',
                'pages_read_engagement',
                'pages_manage_posts',
                'instagram_basic',
                'instagram_content_publish',
                'instagram_manage_insights',
            ],
            'linkedin' => [
                'openid',
                'profile',
                'email',
                'w_member_social',
            ],
            'google' => [
                'https://www.googleapis.com/auth/youtube.upload',
                'https://www.googleapis.com/auth/youtube.force-ssl',
                'profile',
                'email',
            ],
            default => [],
        };
    }
}
