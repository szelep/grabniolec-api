<?php

declare(strict_types=1);

namespace App\Spotify\Infrastructure\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Spotify\Infrastructure\Client\ClientInterface;
use App\Spotify\Infrastructure\Response\GetCurrentPlaybackResponse;

final readonly class CurrentPlaybackProvider implements ProviderInterface
{
    public function __construct(private ClientInterface $client)
    {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $currentPlayback = $this->client->fetchCurrentPlayback();

        if (null === $currentPlayback) {
            return null;
        }

        return new GetCurrentPlaybackResponse(
            $currentPlayback->title,
            $currentPlayback->getArtistsAsString(),
            sprintf('%s - %s', $currentPlayback->getArtistsAsString(), $currentPlayback->title),
            $currentPlayback->imageUrl
        );
    }
}
