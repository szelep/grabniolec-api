<?php

declare(strict_types=1);

namespace App\Spotify\Infrastructure\OAuth\Url;

interface AuthUrlGeneratorInterface
{
    public function getAuthUrl(string $state): AuthUrl;
}
