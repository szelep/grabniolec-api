<?php

declare(strict_types=1);

namespace App\Spotify\Infrastructure\ApiPlatform\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\SharedKernel\Infrastructure\Util\RequestStateHeaderRetriever;
use App\Spotify\Infrastructure\Api\Response\GetCurrentUserResponse;
use App\Spotify\Infrastructure\HttpClient\Spotify\ClientInterface;

final readonly class CurrentUserProvider implements ProviderInterface
{
    public function __construct(
        private ClientInterface $client,
        private RequestStateHeaderRetriever $headerRetriever
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): GetCurrentUserResponse
    {
        $user = $this->client->fetchCurrentUser($this->headerRetriever->getValue('X-STATE'));

        return new GetCurrentUserResponse($user->name);
    }
}
