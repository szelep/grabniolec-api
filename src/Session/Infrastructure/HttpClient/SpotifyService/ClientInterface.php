<?php

declare(strict_types=1);

namespace App\Session\Infrastructure\HttpClient\SpotifyService;

interface ClientInterface
{
    public function isSessionActive(string $sessionId): bool;
}
