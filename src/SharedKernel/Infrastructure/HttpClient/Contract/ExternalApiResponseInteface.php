<?php

declare(strict_types=1);

namespace App\SharedKernel\Infrastructure\HttpClient\Contract;

interface ExternalApiResponseInteface
{
    public function getContent(): null|array|\stdClass|string;

    public function getStatusCode(): int;
}
