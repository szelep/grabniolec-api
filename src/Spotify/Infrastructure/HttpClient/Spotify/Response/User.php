<?php

declare(strict_types=1);

namespace App\Spotify\Infrastructure\HttpClient\Spotify\Response;

use Symfony\Component\Serializer\Attribute\SerializedName;

final readonly class User
{
    public function __construct(
        #[SerializedName('display_name')]
        public string $name
    ) {
    }
}
