<?php

declare(strict_types=1);

namespace App\Spotify\Infrastructure\Api\Response;

final readonly class GetCurrentPlaybackResponse
{
    public function __construct(
        public string $title,
        public string $artists,
        public string $fullTitle,
        public string $imageUrl,
        public string $songId
    ) {
    }
}
