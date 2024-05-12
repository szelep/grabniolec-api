<?php

declare(strict_types=1);

namespace App\Session\Infrastructure\Api\Response;

final readonly class CreateSessionResponse
{
    public function __construct(
        public string $sessionId,
        public string $redirectUri
    ) {
    }
}
