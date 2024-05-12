<?php

declare(strict_types=1);

namespace App\Spotify\Infrastructure\ApiPlatform\Controller;

use App\SharedKernel\Application\Gateway\SessionGatewayInterface;
use App\Spotify\Infrastructure\HttpClient\Spotify\ClientInterface;
use App\Spotify\Infrastructure\OAuth\Credentials\CredentialsStorageInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;

#[AsController]
final readonly class OAuthCallbackAction
{
    private const string UUID_REGEXP = '/^[0-9a-fA-F]{8}\b-[0-9a-fA-F]{4}\b-[0-9a-fA-F]{4}\b-[0-9a-fA-F]{4}\b-[0-9a-fA-F]{12}$/m';
    public function __construct(
        private ClientInterface $client,
        private CredentialsStorageInterface $credentialsStorage,
        #[Autowire(env: 'CLIENT_BASE_URL')]
        private string $clientBaseUrl,
        private SessionGatewayInterface $sessionGateway
    ) {
    }

    public function __invoke(
        #[MapQueryParameter] string $code,
        #[MapQueryParameter(
            filter: \FILTER_VALIDATE_REGEXP,
            options: ['regexp' => self::UUID_REGEXP],
        )] string $state
    ): RedirectResponse {
        $credentials = $this->client->getCredentialsFromToken($code);
        $this->credentialsStorage->save($state, $credentials);
        $this->sessionGateway->emitAuthenticationSuccess($state);

        $redirectUrl = sprintf(
            '%s/session/%s/confirmation',
            $this->clientBaseUrl,
            $state
        );

        return new RedirectResponse($redirectUrl);
    }
}
