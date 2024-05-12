<?php

declare(strict_types=1);

namespace App\Session\Domain\Entity;

use App\Session\Domain\Repository\SessionRepositoryInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SessionRepositoryInterface::class)]
#[ORM\Table(name: 'session', schema: 'session')]
class Session
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    private string $id;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private \DateTimeImmutable $createdAt;

    #[ORM\Column(enumType: State::class)]
    private State $status;

    public function __construct(SessionId $id)
    {
        $this->id = (string) $id;
        $this->createdAt = new \DateTimeImmutable();
        $this->status = State::Created;
    }

    public function getId(): SessionId
    {
        return new SessionId($this->id);
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getStatus(): State
    {
        return $this->status;
    }

    public function setStatus(State $status): void
    {
        $this->status = $status;
    }
}
