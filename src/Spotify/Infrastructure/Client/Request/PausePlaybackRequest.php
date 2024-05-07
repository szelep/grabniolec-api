<?php

declare(strict_types=1);

namespace App\Spotify\Infrastructure\Client\Request;

use App\SharedKernel\Infrastructure\HttpClient\Request\BaseRestRequest;
use Symfony\Component\HttpFoundation\Request;

class PausePlaybackRequest extends BaseRestRequest
{
    private const ENDPOINT = '/v1/me/player/pause';
    public function __construct(#[\SensitiveParameter] string $token)
    {
        parent::__construct(
            self::ENDPOINT,
            Request::METHOD_PUT
        );

        $this->addHeader('Authorization', sprintf('Bearer %s', $token));
        $this->setPayload([]);
    }
}
