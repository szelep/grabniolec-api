<?php

declare(strict_types=1);

namespace App\SharedKernel\Infrastructure\HttpClient\Contract;

interface TraceableRequestInterface
{
    public function getTrace(): string;
}
