<?php

declare(strict_types=1);

namespace App\Spotify\Infrastructure\Request;

use ApiPlatform\Metadata\Get;
use App\Spotify\Infrastructure\State\CurrentPlaybackProvider;
use App\Spotify\Infrastructure\State\PlaylistsProvider;

#[Get(
    uriTemplate: '/spotify/playlists',
    provider: PlaylistsProvider::class
)]
final readonly class GetPlaylistsRequest
{
}
