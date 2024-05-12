<?php

declare(strict_types=1);

namespace App\Session\Domain\Entity;

use Symfony\Component\Uid\Uuid;
use Webmozart\Assert\Assert;

enum State: string
{
    case Created = 'created';
    case DuringAuthentication = 'during_authentication';
    case Inactive = 'inactive';
    case Authenticated = 'authenticated';
}
