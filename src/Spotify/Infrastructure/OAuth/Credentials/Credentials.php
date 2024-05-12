<?php

declare(strict_types=1);

namespace App\Spotify\Infrastructure\OAuth\Credentials;

use Symfony\Component\Serializer\Attribute\SerializedName;

final readonly class Credentials implements CredentialsInterface
{
    public function __construct(
        #[\SensitiveParameter]
        #[SerializedName('access_token')]
        private string $accessToken,
        #[\SensitiveParameter]
        #[SerializedName('refresh_token')]
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
}
