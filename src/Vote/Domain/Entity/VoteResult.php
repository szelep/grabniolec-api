<?php

declare(strict_types=1);

namespace App\Vote\Domain\Entity;

enum VoteResult: string
{
    case Like = 'like';
    case Dislike = 'dislike';

    public static function values(): array
    {
        return array_map(fn (self $result): string => $result->value, self::cases());
    }
}
