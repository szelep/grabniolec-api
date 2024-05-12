<?php

declare(strict_types=1);

namespace App\Vote\Infrastructure\ApiPlatform\Resource;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use App\Vote\Infrastructure\Api\Request\CreateVoteRequest;
use App\Vote\Infrastructure\Api\Response\CreateVoteResponse;
use App\Vote\Infrastructure\Api\Response\GetSongVotesResponse;
use App\Vote\Infrastructure\ApiPlatform\Processor\VotePostProcessor;
use App\Vote\Infrastructure\ApiPlatform\Provider\SongVotesGetProvider;

#[ApiResource(
    operations: [
        new Post(
            uriTemplate: '/votes/{songId}',
            uriVariables: ['songId'],
            input: CreateVoteRequest::class,
            output: CreateVoteResponse::class,
            processor: VotePostProcessor::class,
        ),
        new Get(
            uriTemplate: '/votes/{songId}',
            uriVariables: ['songId'],
            normalizationContext: [
                'skip_null_values' => false,
            ],
            output: GetSongVotesResponse::class,
            provider: SongVotesGetProvider::class
        )
    ]
)]
final readonly class VoteResource
{
}
