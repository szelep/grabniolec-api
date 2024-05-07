<?php

declare(strict_types=1);

namespace App\Spotify\Infrastructure\Response;

final readonly class Device
{
    public function __construct(
        public string $id,
        public string $name,
        public string $type,
        public string $volumePercent,
    ) {
    }
}
