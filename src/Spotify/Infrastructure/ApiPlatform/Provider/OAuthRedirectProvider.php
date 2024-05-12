<?php

declare(strict_types=1);

namespace App\Spotify\Infrastructure\ApiPlatform\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\SharedKernel\Application\Gateway\SessionGatewayInterface;
use App\Spotify\Infrastructure\OAuth\Url\AuthUrlGeneratorInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Webmozart\Assert\Assert;

final readonly class OAuthRedirectProvider implements ProviderInterface
{
    public function __construct(
        private AuthUrlGeneratorInterface $authUrlGenerator,
        private SessionGatewayInterface $sessionGateway
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): RedirectResponse
    {
        $state = $uriVariables['state'];
        Assert::uuid($state);
        $authUrl = $this->authUrlGenerator->getAuthUrl($state);
        $this->sessionGateway->emitAuthenticationStared($state);

        return new RedirectResponse((string) $authUrl);
    }
}
