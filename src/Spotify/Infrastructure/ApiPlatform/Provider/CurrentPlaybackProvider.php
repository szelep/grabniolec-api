<?php

declare(strict_types=1);

namespace App\Spotify\Infrastructure\ApiPlatform\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\SharedKernel\Infrastructure\Util\RequestStateHeaderRetriever;
use App\Spotify\Infrastructure\Api\Response\GetCurrentPlaybackResponse;
use App\Spotify\Infrastructure\HttpClient\Spotify\ClientInterface;

final readonly class CurrentPlaybackProvider implements ProviderInterface
{
    public function __construct(
        private ClientInterface $client,
        private RequestStateHeaderRetriever $headerRetriever
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): ?GetCurrentPlaybackResponse
    {
        $playback = $this->client->fetchCurrentPlayback($this->headerRetriever->getValue('X-STATE'));
        if (null === $playback) {
            return null;
        }

        return new GetCurrentPlaybackResponse(
            $playback->title,
            $playback->getArtistsAsString(),
            sprintf('%s - %s', $playback->getArtistsAsString(), $playback->title),
            $playback->imageUrl,
            $playback->songId
        );
    }
}
