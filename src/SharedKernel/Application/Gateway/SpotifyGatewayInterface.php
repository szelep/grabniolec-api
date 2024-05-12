<?php

declare(strict_types=1);

namespace App\SharedKernel\Application\Gateway;

use App\SharedKernel\Application\DTO\SharedSongDetails;

interface SpotifyGatewayInterface
{
    public function fetchSongDetailsById(string $songId): ?SharedSongDetails;
}
