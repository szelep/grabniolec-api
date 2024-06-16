<?php

declare(strict_types=1);

namespace App\SharedKernel\Application\Event;

final readonly class VoteCountUpdatedEvent
{
    public function __construct(
        public string $trackId,
        public string $causedByClient,
        public int $likesCount,
        public int $dislikesCount
    ) {
    }
}
