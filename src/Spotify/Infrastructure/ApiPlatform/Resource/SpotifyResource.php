<?php

declare(strict_types=1);

namespace App\Spotify\Infrastructure\ApiPlatform\Resource;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use App\Spotify\Infrastructure\Api\Response\GetCurrentPlaybackResponse;
use App\Spotify\Infrastructure\Api\Response\GetCurrentUserResponse;
use App\Spotify\Infrastructure\ApiPlatform\Controller\OAuthCallbackAction;
use App\Spotify\Infrastructure\ApiPlatform\Provider\CurrentPlaybackProvider;
use App\Spotify\Infrastructure\ApiPlatform\Provider\CurrentUserProvider;
use App\Spotify\Infrastructure\ApiPlatform\Provider\OAuthRedirectProvider;
use App\Spotify\Infrastructure\HttpClient\Spotify\Response\Playback;
use App\Spotify\Infrastructure\HttpClient\Spotify\Response\User;

#[ApiResource(
    operations: [
        new Get(
            uriTemplate: '/spotify/login/{state}',
            uriVariables: [
                'state'
            ],
            openapi: false,
            name: 'spotify_oauth_login',
            provider: OAuthRedirectProvider::class,
        ),
        new Get(
            uriTemplate: '/spotify/callback',
            controller: OAuthCallbackAction::class,
            read: false,
            name: 'spotify_oauth_callback'
        ),
        new Get(
            uriTemplate: '/spotify/me',
            output: GetCurrentUserResponse::class,
            name: 'spotify_me',
            provider: CurrentUserProvider::class,
        ),
        new Get(
            uriTemplate: '/spotify/current',
            output: GetCurrentPlaybackResponse::class,
            name: 'spotify_current',
            provider: CurrentPlaybackProvider::class,
        ),
    ],
)]
final readonly class SpotifyResource
{
}
