<?php

declare(strict_types=1);

namespace App\Spotify\Domain\Exception;

final class UnauthorizedException extends \Exception
{
    public static function withState(string $state): self
    {
        return new self(sprintf(
            'State %s has no credentials set.',
            $state,
        ));
    }
}
