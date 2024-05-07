<?php

declare(strict_types=1);

namespace App\BoundedContext\Infrastructure\Request;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use App\BoundedContext\Infrastructure\Response\CreateSessionResponse;
use App\BoundedContext\Infrastructure\State\SessionJoinProvider;
use App\BoundedContext\Infrastructure\State\SessionPostProcessor;

#[Get(
    uriTemplate: '/sessions/{id}/join',
    name: 'join-session',
    provider: SessionJoinProvider::class,
)]
final readonly class JoinSessionRequest
{
}
