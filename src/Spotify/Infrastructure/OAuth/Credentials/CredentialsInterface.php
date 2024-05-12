<?php

declare(strict_types=1);

namespace App\Spotify\Infrastructure\OAuth\Credentials;

interface CredentialsInterface
{
    public function getAccessToken(): string;
    public function getRefreshToken(): string;
}
