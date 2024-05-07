<?php

declare(strict_types=1);

namespace App\Spotify\Infrastructure\Client\Request;

use App\SharedKernel\Infrastructure\HttpClient\Request\BaseRestRequest;
use Symfony\Component\HttpFoundation\Request;

final class RefreshTokenRequest extends BaseRestRequest
{
    private const string ENDPOINT = '/api/token';
    public function __construct(
        $accessToken,
        #[\SensitiveParameter]
        string $refreshToken,
        #[\SensitiveParameter]
        string $clientId,
        #[\SensitiveParameter]
        string $clientSecret,
    )
    {
        parent::__construct(
            self::ENDPOINT,
            Request::METHOD_POST
        );

        $this->addHeader('Content-Type', 'application/x-www-form-urlencoded');
        $this->addQueryParams([
            'grant_type' => 'refresh_token',
            'client_id' => $clientId,
            'refresh_token' => $refreshToken,
        ]);

        $this->addAdditionalOption('auth_basic', [
            $clientId,
            $clientSecret
        ]);
    }
}
