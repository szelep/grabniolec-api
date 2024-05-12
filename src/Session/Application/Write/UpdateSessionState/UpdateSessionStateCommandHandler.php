<?php

namespace App\Session\Application\Write\UpdateSessionState;

use App\Session\Domain\Entity\SessionId;
use App\Session\Domain\Entity\State;
use App\Session\Domain\Repository\SessionRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class UpdateSessionStateCommandHandler
{
    public function __construct(private SessionRepositoryInterface $sessionRepository)
    {
    }

    public function __invoke(UpdateSessionStateCommand $command)
    {
        $session = $this->sessionRepository->getById(SessionId::fromString($command->sessionId));
        $session->setStatus(State::from($command->sessionState));
        $this->sessionRepository->save($session);
    }
}
