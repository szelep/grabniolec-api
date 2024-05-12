<?php

declare(strict_types=1);

namespace App\Lyrics\Domain\Entity;

use Symfony\Component\Uid\Uuid;
use Webmozart\Assert\Assert;

final readonly class SongId implements \Stringable
{
    public function __construct(public string $uri)
    {
    }

    public static function fromString(string $uri): self
    {
        return new self($uri);
    }

    public function __toString(): string
    {
        return $this->uri;
    }
}
