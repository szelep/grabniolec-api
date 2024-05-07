<?php

namespace App\Spotify\Infrastructure\OAuth;

use League\OAuth2\Client\Provider\ResourceOwnerInterface;

final readonly class SpotifyResourceOwner implements ResourceOwnerInterface
{
    public function __construct(protected array $data)
    {
    }

    public function getId(): string
    {
        return $this->data['id'];
    }

    public function toArray(): array
    {
        return $this->data;
    }
}
