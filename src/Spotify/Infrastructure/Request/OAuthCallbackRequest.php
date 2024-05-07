<?php

declare(strict_types=1);

namespace App\Spotify\Infrastructure\Request;

use ApiPlatform\Metadata\Get;
use App\Spotify\Infrastructure\Controller\OauthCallbackAction;

#[Get(
    uriTemplate: '/spotify/callback',
    controller: OauthCallbackAction::class,
    read: false,
)]
final readonly class OAuthCallbackRequest
{
}
