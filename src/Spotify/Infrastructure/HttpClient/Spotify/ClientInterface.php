<?php

declare(strict_types=1);

namespace App\Spotify\Infrastructure\HttpClient\Spotify;

use App\Spotify\Infrastructure\HttpClient\Spotify\Response\Playback;
use App\Spotify\Infrastructure\HttpClient\Spotify\Response\Track;
use App\Spotify\Infrastructure\HttpClient\Spotify\Response\User;
use App\Spotify\Infrastructure\OAuth\Credentials\CredentialsInterface;

interface ClientInterface
{
    public function getCredentialsFromToken(string $code): CredentialsInterface;
    public function fetchCurrentUser(string $state): User;
    public function fetchCurrentPlayback(string $state): ?Playback;
    public function fetchTrack(string $state, string $songId): ?Track;
}
