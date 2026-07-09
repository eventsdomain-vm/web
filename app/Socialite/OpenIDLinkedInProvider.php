<?php

declare(strict_types=1);

namespace App\Socialite;

use Laravel\Socialite\Two\LinkedInProvider;

class OpenIDLinkedInProvider extends LinkedInProvider
{
    protected $scopes = [];

    protected function mapUserToObject(array $user): \Laravel\Socialite\Two\User
    {
        $id = $user['sub'] ?? $user['id'] ?? null;
        $name = $user['name'] ?? trim(($user['given_name'] ?? '').' '.($user['family_name'] ?? ''));
        $email = $user['email'] ?? null;
        $avatar = $user['picture'] ?? null;

        return (new \Laravel\Socialite\Two\User)->setRaw($user)->map([
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
