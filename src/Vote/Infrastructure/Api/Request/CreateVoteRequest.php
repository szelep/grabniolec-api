<?php

declare(strict_types=1);

namespace App\Vote\Infrastructure\Api\Request;

use App\Vote\Domain\Entity\VoteResult;
use App\Vote\Infrastructure\Validator\UniqueVote;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Uuid;

#[UniqueVote]
final readonly class CreateVoteRequest
{
    public function __construct(
        #[NotBlank]
        #[Uuid]
        public string $sessionId = '',
        #[NotBlank]
        public string $clientId = '',
        #[NotBlank]
        public string $songId = '',
        #[NotBlank]
        #[Choice(callback: [VoteResult::class, 'values'])]
        public string $voteResult = '',
    ) {
    }
}
