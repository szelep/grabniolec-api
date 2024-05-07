<?php

declare(strict_types=1);

namespace App\Spotify\Infrastructure\Request;

use ApiPlatform\Metadata\Get;
use App\Spotify\Infrastructure\State\CurrentPlaybackProvider;
use App\Spotify\Infrastructure\State\DevicesProvider;
use App\Spotify\Infrastructure\State\PlaylistsProvider;

#[Get(
    uriTemplate: '/spotify/devices',
    provider: DevicesProvider::class
)]
final readonly class GetDevicesRequest
{
}
