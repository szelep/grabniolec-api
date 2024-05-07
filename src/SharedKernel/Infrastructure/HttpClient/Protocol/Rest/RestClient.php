<?php

declare(strict_types=1);

namespace App\SharedKernel\Infrastructure\HttpClient\Protocol\Rest;

use App\SharedKernel\Infrastructure\HttpClient\Contract\ExternalApiClientInterface;
use App\SharedKernel\Infrastructure\HttpClient\Contract\ExternalApiRequestInterface;
use App\SharedKernel\Infrastructure\HttpClient\Contract\ExternalApiResponseInteface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Stopwatch\Stopwatch;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

final class RestClient implements ExternalApiClientInterface
{
    private function __construct(
        private readonly HttpClientInterface $httpClient,
        private readonly string $clientName,
        private readonly string $host,
    ) {}

    public static function create(
        HttpClientInterface $httpClient,
        string $host,
        string $clientName,
    ): RestClient {
        $httpClient = $httpClient->withOptions(['base_uri' => $host]);

        return new self(
            $httpClient,
            $clientName,
            $host
        );
    }

    public function request(ExternalApiRequestInterface $request): ExternalApiResponseInteface
    {
        $response = $this->httpClient->request(
            $request->getHttpMethod(),
            $request->getEndpoint(),
            $request->getOptions(),
        );
        $responseContent = $response->getContent(false);
        $responseStatus = $response->getStatusCode();

        return new RestResponse($responseContent, $responseStatus);
    }

    public function getClientName(): string
    {
        return $this->clientName;
    }

    public function getHost(): string
    {
        return $this->host;
    }
}
