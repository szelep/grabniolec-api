<?php

declare(strict_types=1);

namespace App\Spotify\Infrastructure\Client;

use App\SharedKernel\Infrastructure\HttpClient\Contract\ExternalApiClientInterface;
use App\Spotify\Infrastructure\Client\Request\CurrentPlaybackRequest;
use App\Spotify\Infrastructure\Client\Request\GetDevicesRequest;
use App\Spotify\Infrastructure\Client\Request\GetPlaylistsRequest;
use App\Spotify\Infrastructure\Client\Request\RefreshTokenRequest;
use App\Spotify\Infrastructure\Client\ValueObject\CurrentPlayback;
use App\Spotify\Infrastructure\Client\ValueObject\Device;
use App\Spotify\Infrastructure\Client\ValueObject\Playlists;
use App\Spotify\Infrastructure\OAuth\Credentials;
use Psr\Cache\CacheItemPoolInterface;
use Symfony\Component\DependencyInjection\Attribute\Autoconfigure;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\UnwrappingDenormalizer;
use Symfony\Component\Serializer\SerializerInterface;

#[Autoconfigure(lazy: ClientInterface::class)]
final class Client implements ClientInterface
{
    public function __construct(
        private readonly ExternalApiClientInterface $spotifyApiClient,
        private readonly ExternalApiClientInterface $spotifyAuthClient,
        private readonly CacheItemPoolInterface $cache,
        private readonly SerializerInterface $serializer,
        private readonly RequestStack $requestStack,
        #[Autowire(env: 'SPOTIFY_CLIENT_ID')]
        private readonly string $clientId,
        #[\SensitiveParameter]
        #[Autowire(env: 'SPOTIFY_CLIENT_SECRET')]
        private readonly string $clientSecret
    ) {
    }

    public function fetchCurrentPlayback(): ?CurrentPlayback
    {
        $credentials = $this->getCredentials();
        $response = $this->spotifyApiClient->request(new CurrentPlaybackRequest($credentials->getAccessToken()));
        if ($response->getStatusCode() === 200) {
            return $this->serializer
                ->deserialize(
                    $response->getContent(),
                    CurrentPlayback::class,
                    JsonEncoder::FORMAT,
                );
        }

        return null;
    }

    public function refreshToken(): void
    {
        $credentials = $this->getCredentials();
        $response = $this->spotifyAuthClient->request(new RefreshTokenRequest(
            $credentials->getAccessToken(),
            $credentials->getRefreshToken(),
            $this->clientId,
            $this->clientSecret
        ));
        if ($response->getStatusCode() !== Response::HTTP_OK) {
            throw new \RuntimeException((string) $response->getStatusCode());
        }
        $decoded = json_decode($response->getContent(), true);
        $cacheItem = $this->cache->getItem($this->sessionId ?? throw new \RuntimeException('SessionId not set'));
        $cacheItem->set(new Credentials(
            $decoded['access_token'],
            $credentials->getRefreshToken()
        ));
        $this->cache->save($cacheItem);
    }

    private function getCredentials(): Credentials
    {
        $currentRequest = $this->requestStack->getCurrentRequest();
        $sessionId = $currentRequest->headers->get('X-SESSION-ID') ?? throw new \RuntimeException('SessionId not set');
        $cacheItem = $this->cache->getItem($sessionId);
        /** @var Credentials|null $credentials */
        $credentials = $cacheItem->get();
        if (null === $credentials) {
            throw new \RuntimeException('Credentials not set');
        }

        return $credentials;
    }

    public function fetchPlaylists(): Playlists
    {
        $credentials = $this->getCredentials();
        $response = $this->spotifyApiClient->request(new GetPlaylistsRequest($credentials->getAccessToken()));

        return $this->serializer
            ->deserialize(
                $response->getContent(),
                Playlists::class,
                JsonEncoder::FORMAT,
            );
    }

    public function fetchDevices(): array
    {
        $credentials = $this->getCredentials();
        $response = $this->spotifyApiClient->request(new GetDevicesRequest($credentials->getAccessToken()));

        return $this->serializer
            ->deserialize(
                $response->getContent(),
                Device::class.'[]',
                JsonEncoder::FORMAT,
                [
                    UnwrappingDenormalizer::UNWRAP_PATH => '[devices]',
                ]
            );
    }
}
