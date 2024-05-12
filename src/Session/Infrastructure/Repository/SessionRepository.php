<?php

declare(strict_types=1);

namespace App\Session\Infrastructure\Repository;

use App\Session\Domain\Entity\Session;
use App\Session\Domain\Entity\SessionId;
use App\Session\Domain\Repository\SessionRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Session>
 */
final class SessionRepository extends ServiceEntityRepository implements SessionRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Session::class);
    }

    public function save(Session $session): void
    {
        $this->getEntityManager()->persist($session);
        $this->getEntityManager()->flush();
    }

    public function getById(SessionId $sessionId): Session
    {
        return $this->find((string) $sessionId) ?? throw EntityNotFoundException::fromClassNameAndIdentifier(Session::class, ['id' => $sessionId]);
    }
}
