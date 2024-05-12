<?php

declare(strict_types=1);

namespace App\Spotify\Infrastructure\HttpClient\Spotify\Request;

use App\SharedKernel\Infrastructure\HttpClient\Contract\SwitchablePayloadOptionInterface;
use App\SharedKernel\Infrastructure\HttpClient\Request\BaseRestRequest;
use Symfony\Component\HttpFoundation\Request;

final class GetTokenFromCodeRequest extends BaseRestRequest
{
    private const string ENDPOINT = '/api/token';
    private const string GRANT_TYPE = 'authorization_code';
    private const string CONTENT_TYPE = 'application/x-www-form-urlencoded';

    public function __construct(
        #[\SensitiveParameter]
        string $code,
        #[\SensitiveParameter]
        string $clientId,
        #[\SensitiveParameter]
        string $clientSecret,
        string $redirectUri
    ) {
        parent::__construct(
            self::ENDPOINT,
            Request::METHOD_POST,
            SwitchablePayloadOptionInterface::BODY
        );

        $this->addQueryParams([
            'code' => $code,
            'grant_type' => self::GRANT_TYPE,
            'redirect_uri' => $redirectUri,
        ]);
        $this->addHeaders([
            'Content-Type' => self::CONTENT_TYPE,
        ]);
        $this->setAdditionalOptions([
            'auth_basic' => [$clientId, $clientSecret],
        ]);
    }
}
