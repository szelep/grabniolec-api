<?php

declare(strict_types=1);

namespace App\Spotify\Infrastructure\Gateway;

use App\SharedKernel\Application\DTO\SharedTrackDetails;
use App\SharedKernel\Application\Gateway\SpotifyGatewayInterface;
use App\SharedKernel\Infrastructure\Util\RequestStateHeaderRetriever;
use App\Spotify\Infrastructure\HttpClient\Spotify\ClientInterface;

final readonly class SpotifyGateway implements SpotifyGatewayInterface
{
    public function __construct(
        private ClientInterface $client,
        private RequestStateHeaderRetriever $headerRetriever
    ) {
    }

    public function fetchTrackDetailsById(string $songId): ?SharedTrackDetails
    {
        $track = $this->client->fetchTrack($this->headerRetriever->getValue('X-STATE'), $songId);
        if (null === $track) {
            return null;
        }

        return new SharedTrackDetails((string) $track);
    }

    public function skipTrack(string $deviceId): void
    {
        $this->client->skipTrack($this->headerRetriever->getValue('X-STATE'), $deviceId);
    }
}
