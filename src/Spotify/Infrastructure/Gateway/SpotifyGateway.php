<?php

declare(strict_types=1);

namespace App\Spotify\Infrastructure\Gateway;

use App\SharedKernel\Application\DTO\SharedSongDetails;
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

    public function fetchSongDetailsById(string $songId): ?SharedSongDetails
    {
        $track = $this->client->fetchTrack($this->headerRetriever->getValue('X-STATE'), $songId);
        if (null === $track) {
            return null;
        }

        return new SharedSongDetails((string) $track);
    }
}
