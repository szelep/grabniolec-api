<?php

declare(strict_types=1);

namespace App\Lyrics\Domain\Entity;

enum Status: string
{
    case Downloaded = 'downloaded';
    case NotFound = 'not_found';
    case Queued = 'queued';
}
