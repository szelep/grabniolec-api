<?php

declare(strict_types=1);

namespace App\SharedKernel\Infrastructure\HttpClient\Contract;

interface ReferableRequestInterface
{
    public function getReference(): ?string;
}
