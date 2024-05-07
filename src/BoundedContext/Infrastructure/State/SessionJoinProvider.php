<?php

declare(strict_types=1);

namespace App\BoundedContext\Infrastructure\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use ApiPlatform\State\ProviderInterface;
use App\BoundedContext\Domain\Entity\Session;
use App\BoundedContext\Domain\Entity\SessionId;
use App\BoundedContext\Domain\Repository\SessionRepositoryInterface;
use App\BoundedContext\Infrastructure\Response\CreateSessionResponse;
use chillerlan\QRCode\QRCode;

final readonly class SessionJoinProvider implements ProviderInterface
{
    public function __construct(
        private SessionRepositoryInterface $sessionRepository
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $id = $uriVariables['id'];

        return $this->sessionRepository->getById(SessionId::fromString($id));
    }
}
