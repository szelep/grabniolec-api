<?php

declare(strict_types=1);

namespace App\SharedKernel\Infrastructure\HttpClient\Contract;

interface ExternalApiClientInterface
{
    public function request(ExternalApiRequestInterface $request): ExternalApiResponseInteface;

    public function getClientName(): string;

    public function getHost(): string;
}
