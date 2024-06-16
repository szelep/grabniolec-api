<?php

declare(strict_types=1);

namespace App\SharedKernel\Application\Gateway;

use App\SharedKernel\Application\DTO\SharedTrackDetails;

interface SpotifyGatewayInterface
{
    public function fetchTrackDetailsById(string $songId): ?SharedTrackDetails;
    public function skipTrack(string $deviceId): void;
}
