<?php

declare(strict_types=1);

namespace App\Spotify\Infrastructure\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Spotify\Infrastructure\OAuth\AuthUrlGeneratorInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

final readonly class OAuthRedirectProvider implements ProviderInterface
{
    public function __construct(private AuthUrlGeneratorInterface $authUrlGenerator)
    {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $authUrl = $this->authUrlGenerator->getAuthUrl($uriVariables['sessionId']);

        return new RedirectResponse($authUrl);
    }
}
