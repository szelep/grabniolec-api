<?php

declare(strict_types=1);

namespace App\Session\Infrastructure\HttpClient\SpotifyService;

use App\Session\Infrastructure\HttpClient\SpotifyService\Request\CheckSessionActiveRequest;
use App\SharedKernel\Infrastructure\HttpClient\Contract\ExternalApiClientInterface;
use Symfony\Component\HttpFoundation\Response;

final readonly class SpotifyServiceClient implements ClientInterface
{
    public function __construct(private ExternalApiClientInterface $spotifyServiceClient)
    {
    }

    public function isSessionActive(string $sessionId): bool
    {
        $response = $this->spotifyServiceClient->request(new CheckSessionActiveRequest($sessionId));

        return $response->getStatusCode() === Response::HTTP_NO_CONTENT;
    }
}
