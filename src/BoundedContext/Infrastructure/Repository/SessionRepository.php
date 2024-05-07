<?php

declare(strict_types=1);

namespace App\BoundedContext\Infrastructure\Repository;

use App\BoundedContext\Domain\Entity\Session;
use App\BoundedContext\Domain\Entity\SessionId;
use App\BoundedContext\Domain\Repository\SessionRepositoryInterface;
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
