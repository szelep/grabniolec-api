<?php

declare(strict_types=1);

namespace App\Spotify\Infrastructure\HttpClient\Spotify\Request;

use App\SharedKernel\Infrastructure\HttpClient\Request\BaseRestRequest;
use Symfony\Component\HttpFoundation\Request;

final class SkipTrackRequest extends BaseRestRequest
{
    private const string ENDPOINT = '/v1/me/player/next';

    public function __construct(
        #[\SensitiveParameter]
        string $token,
        string $deviceId
    ) {
        parent::__construct(
            self::ENDPOINT,
            Request::METHOD_POST
        );

        $this->setPayload(['deviceId' => $deviceId]);
        $this->addHeader('Authorization', sprintf('Bearer %s', $token));
    }
}
