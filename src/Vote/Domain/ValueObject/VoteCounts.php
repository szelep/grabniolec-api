<?php

declare(strict_types=1);

namespace App\Vote\Domain\ValueObject;

final readonly class VoteCounts
{
    public function __construct(
        public int $likes,
        public int $dislikes
    ) {
    }
}
