<?php

declare(strict_types=1);

namespace App\Vote\Application\Write\CreateVote;

use ApiPlatform\Validator\ValidatorInterface;
use App\SharedKernel\Application\Event\VoteCountUpdatedEvent;
use App\Vote\Domain\Entity\ClientId;
use App\Vote\Domain\Entity\SessionId;
use App\Vote\Domain\Entity\SongId;
use App\Vote\Domain\Entity\Vote;
use App\Vote\Domain\Entity\VoteId;
use App\Vote\Domain\Entity\VoteResult;
use App\Vote\Domain\Repository\VoteRepositoryInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class CreateVoteCommandHandler
{
    public function __construct(
        private VoteRepositoryInterface $voteRepository,
        private ValidatorInterface $validator,
        private EventDispatcherInterface $dispatcher
    ) {
    }

    public function __invoke(CreateVoteCommand $command): void
    {
        $voteId = VoteId::generate();
        $vote = new Vote(
            $voteId,
            SessionId::fromString($command->sessionId),
            ClientId::fromString($command->clientId),
            SongId::fromString($command->songId),
            VoteResult::from($command->voteResult)
        );
        $this->validator->validate($vote);
        $this->voteRepository->save($vote);

        $currentVoteCounts = $this->voteRepository->getCountsBySongId($vote->getSongId());
        $this->dispatcher->dispatch(new VoteCountUpdatedEvent(
            (string) $vote->getSongId(),
            (string) $vote->getSessionId(),
            $currentVoteCounts->likes,
            $currentVoteCounts->dislikes
        ));
    }
}
