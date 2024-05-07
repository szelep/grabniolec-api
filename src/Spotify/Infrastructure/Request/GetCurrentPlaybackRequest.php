<?php

declare(strict_types=1);

namespace App\Spotify\Infrastructure\Request;

use ApiPlatform\Metadata\Get;
use App\Spotify\Infrastructure\State\CurrentPlaybackProvider;

#[Get(
    uriTemplate: '/player/current',
    provider: CurrentPlaybackProvider::class,
)]
final readonly class GetCurrentPlaybackRequest
{

}
