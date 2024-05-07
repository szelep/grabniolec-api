<?php

declare(strict_types=1);

namespace App\Spotify\Infrastructure\OAuth;

use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\ResourceOwnerInterface;
use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Tool\BearerAuthorizationTrait;
use Psr\Http\Message\ResponseInterface;

final class SpotifyProvider extends AbstractProvider
{
    use BearerAuthorizationTrait;

    public const string BASE_SPOTIFY_URL = 'https://accounts.spotify.com/';
    public const string RESPONSE_TYPE = 'code';

    public function __construct(array $options = [], array $collaborators = [])
    {
        $options['responseType'] = self::RESPONSE_TYPE;

        parent::__construct($options, $collaborators);
    }

    public function getBaseAuthorizationUrl(): string
    {
        return self::BASE_SPOTIFY_URL.'authorize';
    }

    /**
     * Returns the base URL for requesting an access token.
     */
    public function getBaseAccessTokenUrl(array $params): string
    {
        return self::BASE_SPOTIFY_URL.'api/token';
    }

    /**
     * Returns the URL for requesting the resource owner's details.
     */
    public function getResourceOwnerDetailsUrl(AccessToken $token): string
    {
        return 'https://api.spotify.com/v1/me';
    }

    protected function getDefaultScopes(): array
    {
        return [];
    }

    protected function checkResponse(ResponseInterface $response, $data): void
    {
        if ($response->getStatusCode() >= 400) {
            $error = $data['error_description'] ?? $data['error'] ?? $response->getReasonPhrase();

            if (\is_array($data['error'])) {
                $error = $data['error']['message'];
            }

            throw new \RuntimeException($error);
        }
    }

    protected function createResourceOwner(array $response, AccessToken $token): ResourceOwnerInterface
    {
        return new SpotifyResourceOwner($response);
    }
}
