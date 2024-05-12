<?php

declare(strict_types=1);

namespace App\Vote\Infrastructure\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute(\Attribute::TARGET_CLASS)]
class UniqueVote extends Constraint
{
    public function getTargets(): string|array
    {
        return [self::CLASS_CONSTRAINT];
    }
}
