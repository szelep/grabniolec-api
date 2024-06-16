<?php

declare(strict_types=1);

namespace App\Vote\Infrastructure\ApiPlatform\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use ApiPlatform\Validator\ValidatorInterface;
use App\Vote\Application\Write\CreateVote\CreateVoteCommand;
use App\Vote\Infrastructure\Api\Request\CreateVoteRequest;
use App\Vote\Infrastructure\Api\Response\CreateVoteResponse;
use Symfony\Component\Messenger\MessageBusInterface;

final readonly class VotePostProcessor implements ProcessorInterface
{
    public function __construct(
        private MessageBusInterface $messageBus,
        private ValidatorInterface $validator
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): CreateVoteResponse
    {
        assert($data instanceof CreateVoteRequest);
        $this->validator->validate($data);
        $this->messageBus->dispatch(new CreateVoteCommand(
            $data->sessionId,
            $data->clientId,
            $data->songId,
            $data->voteResult
        ));

        return new CreateVoteResponse();
    }
}
