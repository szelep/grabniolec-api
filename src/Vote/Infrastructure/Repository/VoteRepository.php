<?php

declare(strict_types=1);

namespace App\Vote\Infrastructure\Repository;

use App\Vote\Domain\Entity\ClientId;
use App\Vote\Domain\Entity\SongId;
use App\Vote\Domain\Entity\VoteId;
use App\Vote\Domain\Entity\Vote;
use App\Vote\Domain\Entity\VoteResult;
use App\Vote\Domain\Repository\VoteRepositoryInterface;
use App\Session\Domain\Entity\Session;
use App\Vote\Domain\ValueObject\VoteCounts;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Vote>
 */
final class VoteRepository extends ServiceEntityRepository implements VoteRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Vote::class);
    }

    public function save(Vote $vote): void
    {
        $this->getEntityManager()->persist($vote);
        $this->getEntityManager()->flush();
    }

    public function getById(VoteId $voteId): Vote
    {
        return $this->find((string) $voteId) ?? throw EntityNotFoundException::fromClassNameAndIdentifier(Vote::class, ['id' => $voteId]);
    }

    public function findBySongAndClient(SongId $songId, ClientId $clientId): ?Vote
    {
        return $this->findOneBy([
            'songId' => (string) $songId,
            'clientId' => (string) $clientId
        ]);
    }

    public function getCountsBySongId(SongId $songId): VoteCounts
    {
        $counts = $this
            ->createQueryBuilder('v')
            ->select('v.songId', 'SUM(CASE WHEN v.voteResult = :like THEN 1 ELSE 0 END) AS like_count', 'SUM(CASE WHEN v.voteResult = :dislike THEN 1 ELSE 0 END) AS dislike_count')
            ->setParameter('like', VoteResult::Like->value)
            ->setParameter('dislike', VoteResult::Dislike->value)
            ->groupBy('v.songId')
            ->andWhere('v.songId = :songId')
            ->setParameter('songId', $songId)
            ->setMaxResults(1)
            ->getQuery()
            ->getResult()
        ;

        return new VoteCounts($counts[0]['like_count'] ?? 0, $counts[0]['dislike_count'] ?? 0);
    }
}
