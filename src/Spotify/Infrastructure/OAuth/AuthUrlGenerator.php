<?php

declare(strict_types=1);

namespace App\Spotify\Infrastructure\OAuth;

use Symfony\Component\Uid\Uuid;

final readonly class AuthUrlGenerator implements AuthUrlGeneratorInterface
{
    public function __construct(
        private SpotifyProviderFactory $providerFactory
    ) {
    }

    public function getAuthUrl(?string $state = null): string
    {
        $provider = $this->providerFactory->create();

        return $provider->getAuthorizationUrl([
            'scope' => SpotifyScope::values(),
            'state' => $state ?? Uuid::v4()->toRfc4122(),
        ]);
    }
}
