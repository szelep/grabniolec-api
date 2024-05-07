<?php

declare(strict_types=1);

namespace App\Spotify\Infrastructure\Client\Request;

use App\SharedKernel\Infrastructure\HttpClient\Request\BaseRestRequest;
use Symfony\Component\HttpFoundation\Request;

final class GetDevicesRequest extends BaseRestRequest
{
    private const string ENDPOINT = '/v1/me/player/devices';
    public function __construct(#[\SensitiveParameter] string $token)
    {
        parent::__construct(
            self::ENDPOINT,
            Request::METHOD_GET
        );

        $this->addHeader('Authorization', sprintf('Bearer %s', $token));
    }
}
