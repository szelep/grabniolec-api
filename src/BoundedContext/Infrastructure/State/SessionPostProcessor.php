<?php

declare(strict_types=1);

namespace App\BoundedContext\Infrastructure\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\BoundedContext\Domain\Entity\Session;
use App\BoundedContext\Domain\Entity\SessionId;
use App\BoundedContext\Domain\Repository\SessionRepositoryInterface;
use App\BoundedContext\Infrastructure\Response\CreateSessionResponse;
use App\BoundedContext\Infrastructure\Util\SessionQrGenerator;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;

final readonly class SessionPostProcessor implements ProcessorInterface
{
    public function __construct(
        private SessionRepositoryInterface $sessionRepository,
        private SessionQrGenerator $sessionQrGenerator,
        private RouterInterface $router
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = [])
    {
        $session = new Session(SessionId::generate());
        $this->sessionRepository->save($session);

        return new CreateSessionResponse(
            (string) $session->getId(),
            $session->getCreatedAt(),
            $this->sessionQrGenerator->generateForUuid((string) $session->getId()),
            $this->router->generate(
                'spotify_login',
                ['sessionId' => (string) $session->getId()],
                referenceType: UrlGeneratorInterface::ABSOLUTE_URL
            )
        );
    }
}
