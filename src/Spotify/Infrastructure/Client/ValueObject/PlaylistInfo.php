<?php

declare(strict_types=1);

namespace App\Spotify\Infrastructure\Client\ValueObject;

use Symfony\Component\Serializer\Attribute\SerializedPath;

final readonly class PlaylistInfo
{
    public function __construct(
        #[SerializedPath('[images][0][url]')]
        public string $imageUrl,
        public string $name,
    ) {
    }
}
