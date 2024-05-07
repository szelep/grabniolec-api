<?php

declare(strict_types=1);

namespace App\Spotify\Infrastructure\Request;

use ApiPlatform\Metadata\Get;
use App\Spotify\Infrastructure\Controller\OauthCallbackAction;
use App\Spotify\Infrastructure\State\OAuthRedirectProvider;

#[Get(
    uriTemplate: '/spotify/login/{sessionId}',
    uriVariables: [
        'sessionId'
    ],
    openapi: false,
    name: 'spotify_login',
    provider: OAuthRedirectProvider::class,
)]
final readonly class OAuthLoginRequest
{
}
