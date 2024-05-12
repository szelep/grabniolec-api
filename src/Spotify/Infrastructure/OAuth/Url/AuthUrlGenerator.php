<?php

declare(strict_types=1);

namespace App\Spotify\Infrastructure\OAuth\Url;

use App\Spotify\Infrastructure\OAuth\ConfigurationProvider;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;

final readonly class AuthUrlGenerator implements AuthUrlGeneratorInterface
{
    private const string AUTHORIZE_ENDPOINT = '/authorize';
    private const string RESPONSE_TYPE = 'code';
    private const string APPROVAL_PROMPT = 'auto';
    public function __construct(
        private ConfigurationProvider $configuration,
        private RouterInterface $router
    ) {
    }

    public function getAuthUrl(string $state): AuthUrl
    {
        return new AuthUrl(
            $this->configuration->getSpotifyAuthApiUrl() . self::AUTHORIZE_ENDPOINT,
            SpotifyScope::values(),
            $state,
            self::RESPONSE_TYPE,
            self::APPROVAL_PROMPT,
            $this->router->generate('spotify_oauth_callback', referenceType: UrlGeneratorInterface::ABSOLUTE_URL),
            $this->configuration->getClientId()
        );
    }
}
