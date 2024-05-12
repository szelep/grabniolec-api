<?php

declare(strict_types=1);

namespace App\Spotify\Infrastructure\HttpClient\Spotify\Request;

use App\SharedKernel\Infrastructure\HttpClient\Request\BaseRestRequest;
use Symfony\Component\HttpFoundation\Request;

final class GetTrackRequest extends BaseRestRequest
{
    private const string ENDPOINT_TEMPLATE = '/v1/tracks/{id}';

    public function __construct(
        #[\SensitiveParameter]
        string $token,
        string $songId
    ) {
        parent::__construct(
            str_replace('{id}', $songId, self::ENDPOINT_TEMPLATE),
            Request::METHOD_GET
        );

        $this->addHeader('Authorization', sprintf('Bearer %s', $token));
    }
}
