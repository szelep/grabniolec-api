<?php

declare(strict_types=1);

namespace App\Spotify\Infrastructure\OAuth;

use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;

final readonly class SpotifyProviderFactory
{
    public function __construct(
        private RouterInterface $router,
        #[Autowire(env: 'SPOTIFY_CLIENT_ID')]
        private string $clientId,
        #[\SensitiveParameter]
        #[Autowire(env: 'SPOTIFY_CLIENT_SECRET')]
        private string $clientSecret
    ) {
    }

    public function create(): SpotifyProvider
    {
        $callbackUrl = $this->router->generate(
            '_api_/spotify/callback_get',
            referenceType: UrlGeneratorInterface::ABSOLUTE_URL
        );

        return new SpotifyProvider([
            'clientId'     => $this->clientId,
            'clientSecret' => $this->clientSecret,
            'redirectUri'  => $callbackUrl,
            'show_dialog'=> false,
        ]);
    }
}
