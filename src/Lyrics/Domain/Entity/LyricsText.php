<?php

declare(strict_types=1);

namespace App\Lyrics\Domain\Entity;

use Symfony\Component\Uid\Uuid;
use Webmozart\Assert\Assert;

final readonly class LyricsText implements \Stringable
{
    public function __construct(public string $text)
    {
    }

    public static function fromString(string $text): self
    {
        return new self($text);
    }

    public function __toString(): string
    {
        return $this->text;
    }
}
