<?php

declare(strict_types=1);

namespace App\Spotify\Infrastructure\OAuth;

use Symfony\Component\DependencyInjection\Attribute\Autowire;

final readonly class ConfigurationProvider
{
    public function __construct(
        #[\SensitiveParameter]
        #[Autowire(env: 'SPOTIFY_CLIENT_ID')]
        private string $clientId,
        #[Autowire(env: 'SPOTIFY_AUTH_API_URL')]
        private string $spotifyAuthApiUrl,
        #[\SensitiveParameter]
        #[Autowire(env: 'SPOTIFY_CLIENT_SECRET')]
        private string $clientSecret,
    ) {
    }

    public function getClientId(): string
    {
        return $this->clientId;
    }

    public function getClientSecret(): string
    {
        return $this->clientSecret;
    }

    public function getSpotifyAuthApiUrl(): string
    {
        return rtrim($this->spotifyAuthApiUrl, '/');
    }

}
