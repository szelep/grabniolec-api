<?php

declare(strict_types=1);

namespace App\Spotify\Infrastructure\Controller;

use App\Spotify\Infrastructure\OAuth\Credentials;
use App\Spotify\Infrastructure\OAuth\SpotifyProviderFactory;
use Psr\Cache\CacheItemPoolInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
final readonly class OauthCallbackAction
{
    public function __construct(
        private CacheItemPoolInterface $cache,
        private SpotifyProviderFactory $providerFactory
    ) {
    }

    public function __invoke(Request $request)
    {
        $provider = $this->providerFactory->create();
        $accessToken = $provider->getAccessToken('authorization_code', [
            'code' => $request->query->get('code')
        ]);
        $state = $request->query->get('state');
        $credentials = Credentials::fromOAuthAccessToken($accessToken);

        $cacheItem = $this->cache->getItem($state);
        $cacheItem->set($credentials);
        $this->cache->save($cacheItem);

        $redirectUrl = sprintf(
            '%s/session/%s/confirmation',
            'http://grabniolec.pl',
            $state
        );

        return new RedirectResponse($redirectUrl);
    }
}
