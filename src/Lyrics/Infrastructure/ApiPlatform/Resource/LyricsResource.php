<?php

declare(strict_types=1);

namespace App\Lyrics\Infrastructure\ApiPlatform\Resource;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use App\Lyrics\Infrastructure\ApiPlatform\Provider\LyricsProvider;

#[ApiResource(
    operations: [
        new Get(
            uriTemplate: '/lyrics/{songId}',
            uriVariables: [
                'songId',
            ],
            provider: LyricsProvider::class,
        )
    ]
)]
final readonly class LyricsResource
{
}
