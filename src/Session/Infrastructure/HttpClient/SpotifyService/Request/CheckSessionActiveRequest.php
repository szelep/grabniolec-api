<?php

declare(strict_types=1);

namespace App\Session\Infrastructure\HttpClient\SpotifyService\Request;

use App\SharedKernel\Infrastructure\HttpClient\Request\BaseRestRequest;
use Symfony\Component\HttpFoundation\Request;

final class CheckSessionActiveRequest extends BaseRestRequest
{
    private const string ENDPOINT = '/api/spotify/active';
    private const string HEADER_KEY = 'X-STATE-ID';

    public function __construct(
        string $sessionId
    ) {
        parent::__construct(self::ENDPOINT, Request::METHOD_GET);

        $this->addHeader(self::HEADER_KEY, $sessionId);
    }
}
