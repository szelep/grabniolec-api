<?php

declare(strict_types=1);

namespace App\Lyrics\Infrastructure\Api;

final readonly class GetLyricsResponse
{
    public function __construct(
        public string $id,
        public string $lyricsText,
        public string $status
    ) {
    }
}
