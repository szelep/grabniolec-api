<?php

declare(strict_types=1);

namespace App\Spotify\Infrastructure\OAuth;

interface AuthUrlGeneratorInterface
{
    public function getAuthUrl(?string $state = null): string;
}
