<?php

declare(strict_types=1);

namespace App\Spotify\Infrastructure\HttpClient\Spotify;

use App\SharedKernel\Infrastructure\HttpClient\Contract\ExternalApiClientInterface;
use App\Spotify\Domain\Exception\UnauthorizedException;
use App\Spotify\Domain\Exception\UnexpectedClientResponseException;
use App\Spotify\Infrastructure\HttpClient\Spotify\Request\GetCurrentPlaybackRequest;
use App\Spotify\Infrastructure\HttpClient\Spotify\Request\GetCurrentUserRequest;
use App\Spotify\Infrastructure\HttpClient\Spotify\Request\GetTokenFromCodeRequest;
use App\Spotify\Infrastructure\HttpClient\Spotify\Request\GetTrackRequest;
use App\Spotify\Infrastructure\HttpClient\Spotify\Request\SkipTrackRequest;
use App\Spotify\Infrastructure\HttpClient\Spotify\Response\Playback;
use App\Spotify\Infrastructure\HttpClient\Spotify\Response\Track;
use App\Spotify\Infrastructure\HttpClient\Spotify\Response\User;
use App\Spotify\Infrastructure\OAuth\ConfigurationProvider;
use App\Spotify\Infrastructure\OAuth\Credentials\Credentials;
use App\Spotify\Infrastructure\OAuth\Credentials\CredentialsInterface;
use App\Spotify\Infrastructure\OAuth\Credentials\CredentialsStorageInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

final readonly class SpotifyClient implements ClientInterface
{
    public function __construct(
        private ConfigurationProvider $configuration,
        private ExternalApiClientInterface $spotifyAuthClient,
        private ExternalApiClientInterface $spotifyApiClient,
        private RouterInterface $router,
        private SerializerInterface $serializer,
        private CredentialsStorageInterface $credentialsStorage
    ) {
    }

    /**
     * @throws UnexpectedClientResponseException
     */
    public function getCredentialsFromToken(string $code): Credentials
    {
        $request = new GetTokenFromCodeRequest(
            $code,
            $this->configuration->getClientId(),
            $this->configuration->getClientSecret(),
            $this->router->generate('spotify_oauth_callback', referenceType: UrlGeneratorInterface::ABSOLUTE_URL),
        );

        $response = $this->spotifyAuthClient->request($request);
        if ($response->getStatusCode() !== Response::HTTP_OK) {
            throw new UnexpectedClientResponseException();
        }

        return $this->serializer->deserialize(
            $response->getContent(),
            Credentials::class,
            JsonEncoder::FORMAT
        );
    }

    public function fetchCurrentUser(string $state): User
    {
        $credentials = $this->getCredentials($state);
        $response = $this->spotifyApiClient->request(new GetCurrentUserRequest($credentials->getAccessToken()));
        if ($response->getStatusCode() === Response::HTTP_UNAUTHORIZED) {
            throw new UnauthorizedException();
        }
        if ($response->getStatusCode() !== Response::HTTP_OK) {
            throw new UnexpectedClientResponseException();
        }

        return $this->serializer->deserialize(
            $response->getContent(),
            User::class,
            JsonEncoder::FORMAT
        );
    }

    public function fetchCurrentPlayback(string $state): ?Playback
    {
        $credentials = $this->getCredentials($state);
        $response = $this->spotifyApiClient->request(new GetCurrentPlaybackRequest($credentials->getAccessToken()));
        if ($response->getStatusCode() === Response::HTTP_UNAUTHORIZED) {
            throw new UnauthorizedException();
        }
        if ($response->getStatusCode() !== Response::HTTP_OK) {
            return null;
        }

        return $this->serializer->deserialize(
            $response->getContent(),
            Playback::class,
            JsonEncoder::FORMAT
        );
    }

    public function fetchTrack(string $state, string $songId): ?Track
    {
        $credentials = $this->getCredentials($state);
        $response = $this->spotifyApiClient->request(new GetTrackRequest($credentials->getAccessToken(), $songId));
        if ($response->getStatusCode() === Response::HTTP_UNAUTHORIZED) {
            throw new UnauthorizedException();
        }
        if ($response->getStatusCode() !== Response::HTTP_OK) {
            return null;
        }

        return $this->serializer->deserialize(
            $response->getContent(),
            Track::class,
            JsonEncoder::FORMAT
        );
    }

    private function getCredentials(string $state): CredentialsInterface
    {
        return $this->credentialsStorage->get($state) ?? throw UnauthorizedException::withState($state);
    }

    public function skipTrack(string $state, string $deviceId): void
    {
        $credentials = $this->getCredentials($state);
        $response = $this->spotifyApiClient->request(new SkipTrackRequest($credentials->getAccessToken(), $deviceId));
    }
}
