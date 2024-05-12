<?php

declare(strict_types=1);

namespace App\Session\Infrastructure\ApiPlatform\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Session\Domain\Entity\Session;
use App\Session\Domain\Entity\SessionId;
use App\Session\Domain\Repository\SessionRepositoryInterface;
use App\Session\Infrastructure\Api\Response\CreateSessionResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;

final readonly class SessionPostProcessor implements ProcessorInterface
{
    public function __construct(
        private SessionRepositoryInterface $sessionRepository,
        private RouterInterface $router
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): CreateSessionResponse
    {
        $sessionId = SessionId::generate();
        $session = new Session($sessionId);
        $this->sessionRepository->save($session);

        return new CreateSessionResponse(
            (string) $sessionId,
            $this->router->generate(
                'spotify_oauth_login',
                ['state' => (string) $sessionId]
            )
        );
    }
}
