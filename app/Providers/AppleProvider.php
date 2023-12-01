<?php

namespace App\Providers;

use SocialiteProviders\Manager\OAuth2\AbstractProvider;

class AppleProvider extends AbstractProvider
{
    protected $scopes = ['name', 'email'];

    protected function getAuthUrl($state)
    {
        return $this->buildAuthUrlFromBase('https://appleid.apple.com/auth/authorize', $state);
    }

    protected function getTokenUrl()
    {
        return 'https://appleid.apple.com/auth/token';
    }

    protected function getUserByToken($token)
    {
        $response = $this->getHttpClient()->get('https://appleid.apple.com/auth/user', [
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
            ],
        ]);

        return json_decode($response->getBody(), true);
    }

    protected function mapUserToObject(array $user)
    {
        return (new User)->setRaw($user)->map([
            'id' => $user['sub'],
            'name' => $user['name'],
            'email' => $user['email'],
        ]);
    }
}
