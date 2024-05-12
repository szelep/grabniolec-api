<?php

declare(strict_types=1);

namespace App\Spotify\Infrastructure\OAuth\Credentials;

use Psr\Cache\CacheItemPoolInterface;

final readonly class CachedCredentialsStorage implements CredentialsStorageInterface
{
    public function __construct(private CacheItemPoolInterface $cache)
    {
    }

    public function save(string $code, CredentialsInterface $credentials): void
    {
        $cacheItem = $this->cache->getItem($code);
        $cacheItem->set($credentials);
        $this->cache->save($cacheItem);
    }

    public function get(string $code): ?CredentialsInterface
    {
        $cacheItem = $this->cache->getItem($code);
        if ($cacheItem->isHit()) {
            return $cacheItem->get();
        }

        return null;
    }
}
