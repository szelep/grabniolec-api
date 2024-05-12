<?php

declare(strict_types=1);

namespace App\Vote\Domain\Entity;

final readonly class SongId implements \Stringable
{
    public function __construct(public string $id)
    {
    }

    public static function fromString(string $id): self
    {
        return new self($id);
    }

    public function __toString(): string
    {
        return $this->id;
    }
}
