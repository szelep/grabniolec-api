<?php

declare(strict_types=1);

namespace App\SharedKernel\Domain\Exception;

final class HeaderRequiredException extends \RuntimeException
{
    public static function withHeaderName(string $header): self
    {
        return new self(sprintf(
            '%s header is required to perform this request.',
            $header
        ));
    }
}
