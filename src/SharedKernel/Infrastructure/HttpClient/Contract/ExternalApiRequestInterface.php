<?php

declare(strict_types=1);

namespace App\SharedKernel\Infrastructure\HttpClient\Contract;

use Symfony\Contracts\HttpClient\HttpClientInterface;

interface ExternalApiRequestInterface
{
    public function getHttpMethod(): string;

    public function getPayload(): null|array|\stdClass|string;

    public function getHeaders(): array;

    public function getEndpoint(): string;

    /**
     * Options provided to http client.
     *
     * @see HttpClientInterface::request()
     */
    public function getOptions(): array;
}
