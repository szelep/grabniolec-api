<?php

declare(strict_types=1);

namespace App\Vote\Domain\Repository;

use App\Vote\Domain\Entity\ClientId;
use App\Vote\Domain\Entity\SongId;
use App\Vote\Domain\Entity\Vote;
use App\Vote\Domain\Entity\VoteId;
use App\Vote\Domain\ValueObject\VoteCounts;

interface VoteRepositoryInterface
{
    public function save(Vote $vote): void;
    public function getById(VoteId $voteId): Vote;
    public function exists(Vote $vote): bool;
    public function findBySongAndClient(SongId $songId, ClientId $clientId): ?Vote;
    public function getCountsBySongId(SongId $songId): VoteCounts;
}
