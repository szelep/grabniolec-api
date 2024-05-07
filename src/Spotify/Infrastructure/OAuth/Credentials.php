<?php

declare(strict_types=1);

namespace App\Spotify\Infrastructure\OAuth;

use League\OAuth2\Client\Token\AccessToken;

final readonly class Credentials
{
    public function __construct(
        #[\SensitiveParameter]
        private string $accessToken,
        #[\SensitiveParameter]
        private string $refreshToken
    ) {
    }

    public function getAccessToken(): string
    {
        return $this->accessToken;
    }

    public function getRefreshToken(): string
    {
        return $this->refreshToken;
    }

    public static function fromOAuthAccessToken(AccessToken $accessToken): self
    {
        return new self(
            $accessToken->getToken(),
            $accessToken->getRefreshToken()
        );
    }
}
