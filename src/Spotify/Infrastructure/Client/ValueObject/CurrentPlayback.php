<?php

declare(strict_types=1);

namespace App\Spotify\Infrastructure\Client\ValueObject;

use Symfony\Component\Serializer\Attribute\SerializedPath;

final readonly class CurrentPlayback implements \Stringable
{
    public function __construct(
        #[SerializedPath('[item][name]')]
        public string $title,
        /** @var Artist[] $artists */
        #[SerializedPath('[item][artists]')]
        public array $artists,
        #[SerializedPath('[context][uri]')]
        public string $contextUri,
        #[SerializedPath('[item][album][images][1][url]')]
        public string $imageUrl
    ) {
    }

    public function __toString(): string
    {
        return sprintf(
            '%s - %s',
            $this->getArtistsAsString(),
            $this->title
        );
    }

    public function getArtistsAsString(): string
    {
        return implode(', ', array_map(fn (Artist $artist): string => (string) $artist, $this->artists));
    }
}
