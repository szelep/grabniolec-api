<?php

declare(strict_types=1);

namespace App\Spotify\Infrastructure\Client\ValueObject;

final readonly class Playlists
{
    public function __construct(
        /** @var PlaylistInfo[] $items */
        public array $items = []
    ) {
    }
}
