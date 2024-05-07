<?php

declare(strict_types=1);

namespace App\BoundedContext\Infrastructure\Response;

final readonly class CreateSessionResponse
{
    public function __construct(
        public string $id,
        public \DateTimeImmutable $createdAt,
        public string $qrCode,
        public string $redirectUrl
    ) {
    }
}
