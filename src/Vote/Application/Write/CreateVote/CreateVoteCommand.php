<?php

declare(strict_types=1);

namespace App\Vote\Application\Write\CreateVote;

final readonly class CreateVoteCommand
{
    public function __construct(
        public string $sessionId,
        public string $clientId,
        public string $songId,
        public string $voteResult
    ) {
    }
}
