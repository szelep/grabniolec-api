<?php

declare(strict_types=1);

namespace App\SharedKernel\Infrastructure\HttpClient\Protocol\Rest;

use App\SharedKernel\Infrastructure\HttpClient\Contract\ExternalApiResponseInteface;

class RestResponse implements ExternalApiResponseInteface
{
    public function __construct(private readonly string $content, private readonly int $statusCode) {}

    public function getContent(): string
    {
        return $this->content;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function toArray(): array
    {
        return \json_decode(
            $this->content,
            true,
            512,
            JSON_THROW_ON_ERROR
        );
    }
}
