<?php

declare(strict_types=1);

namespace App\Vote\Infrastructure\ApiPlatform\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use ApiPlatform\Validator\ValidatorInterface;
use App\Vote\Domain\Entity\ClientId;
use App\Vote\Domain\Entity\SessionId;
use App\Vote\Domain\Entity\SongId;
use App\Vote\Domain\Entity\Vote;
use App\Vote\Domain\Entity\VoteId;
use App\Vote\Domain\Entity\VoteResult;
use App\Vote\Domain\Repository\VoteRepositoryInterface;
use App\Vote\Infrastructure\Api\Request\CreateVoteRequest;
use App\Vote\Infrastructure\Api\Response\CreateVoteResponse;

final readonly class VotePostProcessor implements ProcessorInterface
{
    public function __construct(
        private VoteRepositoryInterface $voteRepository,
        private ValidatorInterface $validator
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): CreateVoteResponse
    {
        assert($data instanceof CreateVoteRequest);

        $voteId = VoteId::generate();
        $vote = new Vote(
            $voteId,
            SessionId::fromString($data->sessionId),
            ClientId::fromString($data->clientId),
            SongId::fromString($data->songId),
            VoteResult::from($data->voteResult)
        );
        $this->validator->validate($vote);
        $this->voteRepository->save($vote);

        return new CreateVoteResponse();
    }
}
