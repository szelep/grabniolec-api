<?php

namespace App\SharedKernel\Application\Gateway;

interface SessionGatewayInterface
{
    public function emitAuthenticationStared(string $sessionId): void;
    public function emitAuthenticationSuccess(string $sessionId): void;
}
