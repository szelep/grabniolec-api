<?php

declare(strict_types=1);

namespace App\Spotify\Infrastructure\Response;

final readonly class Playlist
{
    public function __construct(
        public string $name,
        public string $imageUrl
    ) {
    }
}
