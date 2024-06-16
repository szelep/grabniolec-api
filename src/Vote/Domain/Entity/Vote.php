<?php

declare(strict_types=1);

namespace App\Vote\Domain\Entity;

use App\Vote\Domain\Repository\VoteRepositoryInterface;
use App\Vote\Infrastructure\EventListener\OnVoteDoneListener;
use App\Vote\Infrastructure\Validator\UniqueVote;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: VoteRepositoryInterface::class)]
#[ORM\Table(
    name: 'vote',
    schema: 'vote'
)]
#[ORM\Index('idx_songId_voteResult', ['song_id', 'vote_result'])]
class Vote
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    private string $id;
    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private \DateTimeImmutable $createdAt;
    #[ORM\Column(type: Types::TEXT)]
    private string $sessionId;
    #[ORM\Column(type: Types::TEXT)]
    private string $clientId;
    #[ORM\Column(type: Types::TEXT)]
    private string $songId;
    #[ORM\Column(enumType: VoteResult::class)]
    private VoteResult $voteResult;

    public function __construct(
        VoteId $id,
        SessionId $sessionId,
        ClientId $clientId,
        SongId $songId,
        VoteResult $voteResult
    ) {
        $this->id = (string) $id;
        $this->createdAt = new \DateTimeImmutable();
        $this->sessionId = (string) $sessionId;
        $this->clientId = (string) $clientId;
        $this->songId = (string) $songId;
        $this->voteResult = $voteResult;
    }

    public function getId(): VoteId
    {
        return VoteId::fromString($this->id);
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getSessionId(): SessionId
    {
        return SessionId::fromString($this->sessionId);
    }

    public function getClientId(): ClientId
    {
        return ClientId::fromString($this->clientId);
    }

    public function getSongId(): SongId
    {
        return SongId::fromString($this->songId);
    }

    public function getVoteResult(): VoteResult
    {
        return $this->voteResult;
    }
}
