<?php

declare(strict_types=1);

namespace App\Session\Domain\Entity;

use Symfony\Component\Uid\Uuid;
use Webmozart\Assert\Assert;

final readonly class SessionId implements \Stringable
{
    public function __construct(public string $id)
    {
        Assert::uuid($id);
    }

    public static function generate(): self
    {
        return new self(Uuid::v4()->toRfc4122());
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
