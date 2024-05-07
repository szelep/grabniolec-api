<?php

declare(strict_types=1);

namespace App\Spotify\Infrastructure\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Spotify\Infrastructure\Client\ClientInterface;
use App\Spotify\Infrastructure\Client\ValueObject\PlaylistInfo;
use App\Spotify\Infrastructure\Client\ValueObject\Playlists;
use App\Spotify\Infrastructure\Response\GetCurrentPlaybackResponse;
use App\Spotify\Infrastructure\Response\GetPlaylistsResponse;
use App\Spotify\Infrastructure\Response\Playlist;
use Symfony\Component\HttpFoundation\RequestStack;

final readonly class PlaylistsProvider implements ProviderInterface
{
    public function __construct(
        private ClientInterface $client
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $fetchedPlaylists = $this->client->fetchPlaylists();

        $playlists = array_map(fn (PlaylistInfo $playlistInfo): Playlist => new Playlist(
            $playlistInfo->name,
            $playlistInfo->imageUrl
        ), $fetchedPlaylists->items);

        return new GetPlaylistsResponse($playlists);
    }
}
