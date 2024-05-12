<?php

declare(strict_types=1);

namespace App\Session\Infrastructure\Gateway;

use App\Session\Application\Write\UpdateSessionState\UpdateSessionStateCommand;
use App\Session\Domain\Entity\State;
use App\SharedKernel\Application\Gateway\SessionGatewayInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final readonly class SessionGateway implements SessionGatewayInterface
{
    public function __construct(private MessageBusInterface $messageBus)
    {
    }

    public function emitAuthenticationStared(string $sessionId): void
    {
        $this->messageBus->dispatch(new UpdateSessionStateCommand($sessionId, State::DuringAuthentication->value));
    }

    public function emitAuthenticationSuccess(string $sessionId): void
    {
        $this->messageBus->dispatch(new UpdateSessionStateCommand($sessionId, State::Authenticated->value));
    }
}
