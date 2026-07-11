<?php

declare(strict_types=1);

namespace App\Socialite;

use GuzzleHttp\RequestOptions;
use Laravel\Socialite\Two\LinkedInProvider;
use Laravel\Socialite\Two\User;

class OpenIDLinkedInProvider extends LinkedInProvider
{
    protected $scopes = ['openid', 'profile', 'email', 'w_member_social'];

    protected function getUserByToken($token): array
    {
        $response = $this->getHttpClient()->get('https://api.linkedin.com/v2/userinfo', [
            RequestOptions::HEADERS => [
                'Authorization' => 'Bearer '.$token,
            ],
        ]);

        return (array) json_decode((string) $response->getBody(), true);
    }

    protected function mapUserToObject(array $user): User
    {
        $id = $user['sub'] ?? $user['id'] ?? null;
        $name = $user['name'] ?? trim(($user['given_name'] ?? '').' '.($user['family_name'] ?? ''));
        $email = $user['email'] ?? null;
        $avatar = $user['picture'] ?? null;

        return (new User)->setRaw($user)->map([
            'id' => $id,
            'nickname' => null,
            'name' => $name,
            'first_name' => $user['given_name'] ?? null,
            'last_name' => $user['family_name'] ?? null,
            'email' => $email,
            'avatar' => $avatar,
            'avatar_original' => $avatar,
        ]);
    }
}
