<?php

declare(strict_types=1);

namespace App\BoundedContext\Domain\Entity;

use App\BoundedContext\Infrastructure\Repository\SessionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SessionRepository::class)]
#[ORM\Table(name: 'session', schema: 'app')]
class Session
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    private string $id;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private \DateTimeImmutable $createdAt;

    public function __construct(SessionId $id)
    {
        $this->id = (string) $id;
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): SessionId
    {
        return new SessionId($this->id);
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }
}
