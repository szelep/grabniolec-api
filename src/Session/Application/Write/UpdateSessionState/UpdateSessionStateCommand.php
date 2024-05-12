<?php

declare(strict_types=1);

namespace App\Session\Application\Write\UpdateSessionState;

final readonly class UpdateSessionStateCommand
{
    public function __construct(public string $sessionId, public string $sessionState)
    {
    }
}
