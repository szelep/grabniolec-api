<?php

declare(strict_types=1);

namespace App\Vote\Infrastructure\Api\Response;

final readonly class GetSongVotesResponse
{
    public function __construct(
        public int $likeCount,
        public int $dislikeCount,
        public ?string $myVote = null
    ) {
    }
}
