<?php

declare(strict_types=1);

namespace App\SharedKernel\Application\DTO;

final readonly class SharedSongDetails
{
    public function __construct(public string $fullTitle)
    {
    }
}
