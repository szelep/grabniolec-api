<?php

declare(strict_types=1);

namespace App\Session\Infrastructure\ApiPlatform\Resource;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use App\Session\Infrastructure\ApiPlatform\Processor\SessionPostProcessor;

#[ApiResource(
    operations: [
        new Post(
            uriTemplate: '/sessions',
            processor: SessionPostProcessor::class,
        )
    ],
)]
final readonly class SessionResource
{
}
