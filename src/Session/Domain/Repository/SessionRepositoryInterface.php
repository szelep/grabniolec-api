<?php

declare(strict_types=1);

namespace App\Session\Domain\Repository;

use App\Session\Domain\Entity\Session;
use App\Session\Domain\Entity\SessionId;

interface SessionRepositoryInterface
{
    public function save(Session $session): void;
    public function getById(SessionId $sessionId): Session;
}
