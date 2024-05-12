<?php

declare(strict_types=1);

namespace App\Spotify\Infrastructure\HttpClient\Spotify\Response;

final readonly class Artist implements \Stringable
{
    public function __construct(public string $name)
    {
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
