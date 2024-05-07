<?php

declare(strict_types=1);

namespace App\SharedKernel\Infrastructure\HttpClient\Contract;

interface QueryAwareRequestInterface
{
    public function addQueryParam(string $name, string $value): self;

    public function getQueryParts(): array;
}
