<?php

declare(strict_types=1);

namespace App\Lyrics\Infrastructure\Repository;

use App\Lyrics\Domain\Entity\LyricsId;
use App\Lyrics\Domain\Entity\Lyrics;
use App\Lyrics\Domain\Entity\SongId;
use App\Lyrics\Domain\Repository\LyricsRepositoryInterface;
use App\Session\Domain\Entity\Session;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Lyrics>
 */
final class LyricsRepository extends ServiceEntityRepository implements LyricsRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Lyrics::class);
    }

    public function save(Lyrics $lyrics): void
    {
        $this->getEntityManager()->persist($lyrics);
        $this->getEntityManager()->flush();
    }

    public function getById(LyricsId $lyricsId): Lyrics
    {
        return $this->find((string) $lyricsId) ?? throw EntityNotFoundException::fromClassNameAndIdentifier(Lyrics::class, ['id' => $lyricsId]);
    }

    public function findBySongId(SongId $songId): ?Lyrics
    {
        return $this->findOneBy([
            'songId' => (string) $songId
        ]);
    }
}
