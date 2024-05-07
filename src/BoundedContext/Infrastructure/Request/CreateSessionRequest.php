<?php

declare(strict_types=1);

namespace App\BoundedContext\Infrastructure\Request;

use ApiPlatform\Metadata\Post;
use App\BoundedContext\Infrastructure\Response\CreateSessionResponse;
use App\BoundedContext\Infrastructure\State\SessionPostProcessor;

#[Post(
    uriTemplate: '/sessions',
    input: self::class,
    output: CreateSessionResponse::class,
    processor: SessionPostProcessor::class
)]
final readonly class CreateSessionRequest
{
}
