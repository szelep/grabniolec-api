<?php

declare(strict_types=1);

namespace App\BoundedContext\Domain\Repository;

use App\BoundedContext\Domain\Entity\Session;
use App\BoundedContext\Domain\Entity\SessionId;

interface SessionRepositoryInterface
{
    public function save(Session $session): void;
    public function getById(SessionId $sessionId): Session;
}
