<?php

declare(strict_types=1);

namespace App\Spotify\Infrastructure\Api\Response;

final readonly class GetCurrentUserResponse
{
    public function __construct(
        public string $displayName
    ) {
    }
}
