<?php

declare(strict_types=1);

namespace App\Spotify\Infrastructure\Response;

final readonly class GetPlaylistsResponse
{
    public function __construct(
        /** @var Playlist[] $playlists */
        public array $playlists = []
    ) {
    }
}
