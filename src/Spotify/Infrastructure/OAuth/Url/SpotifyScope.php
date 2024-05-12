<?php

declare(strict_types=1);

namespace App\Spotify\Infrastructure\OAuth\Url;

enum SpotifyScope: string
{
    case UserReadPlaybackState = 'user-read-playback-state';
    case UserModifyPlaybackState = 'user-modify-playback-state';
    case UserReadCurrentlyPlaying = 'user-read-currently-playing';
    case AppRemoteControl = 'app-remote-control';
    case PlaylistReadPrivate = 'playlist-read-private';
    case PlaylistReadCollaborative = 'playlist-read-collaborative';
    case UserReadPlaybackPosition = 'user-read-playback-position';
    case UserLibraryRead = 'user-library-read';

    public static function values(): array
    {
        return array_map(fn (self $scope): string => $scope->value, self::cases());
    }
}
