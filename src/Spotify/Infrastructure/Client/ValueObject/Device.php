<?php

declare(strict_types=1);

namespace App\Spotify\Infrastructure\Client\ValueObject;

use Symfony\Component\Serializer\Attribute\SerializedName;

final readonly class Device
{
    public function __construct(
        public string $id,
        public string $name,
        public string $type,
        #[SerializedName('volume_percent')]
        public int $volumePercent,
    ) {
    }
}
