<?php

declare(strict_types=1);

namespace App\Spotify\Infrastructure\OAuth\Url;

final readonly class AuthUrl implements \Stringable
{
    public function __construct(
        private string $url,
        private array $scope,
        private string $state,
        private string $responseType,
        private string $approvalPrompt,
        private string $redirectUri,
        private string $clientId
    ) {
    }

    public function __toString(): string
    {
        $queryParts = [
            'state' => $this->state,
            'scope' => implode(' ', $this->scope),
            'response_type' => $this->responseType,
            'approval_prompt' => $this->approvalPrompt,
            'redirect_uri' => $this->redirectUri,
            'client_id' => $this->clientId,
        ];

        return sprintf(
            '%s?%s',
            $this->url,
            http_build_query($queryParts)
        );
    }
}
