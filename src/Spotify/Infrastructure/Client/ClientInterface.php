<?php

declare(strict_types=1);

namespace App\Spotify\Infrastructure\Client;

use App\Spotify\Infrastructure\Client\ValueObject\CurrentPlayback;
use App\Spotify\Infrastructure\Client\ValueObject\Device;
use App\Spotify\Infrastructure\Client\ValueObject\Playlists;

interface ClientInterface
{
    public function refreshToken(): void;
    public function fetchCurrentPlayback(): ?CurrentPlayback;
    public function fetchPlaylists(): Playlists;
    /**
     * @return Device[]
     */
    public function fetchDevices(): array;
}
