<?php

declare(strict_types=1);

namespace App\Spotify\Infrastructure\HttpClient\Spotify\Response;

final readonly class Track implements \Stringable
{
    public function __construct(
        /** @var Artist[] $artists */
        public array $artists,
        public string $name
    ) {
    }

    public function __toString(): string
    {
        return sprintf(
            '%s - %s',
            $this->getArtistsAsString(),
            $this->name
        );
    }

    public function getArtistsAsString(): string
    {
        return implode(', ', array_map(fn (Artist $artist): string => (string) $artist, $this->artists));
    }
}
