<?php

declare(strict_types=1);

namespace App\Vote\Infrastructure\Validator;

use App\Vote\Domain\Repository\VoteRepositoryInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

final class UniqueVoteValidator extends ConstraintValidator
{
    public function __construct(private VoteRepositoryInterface $voteRepository)
    {
    }

    public function validate($value, Constraint $constraint)
    {
        /* @var UniqueVote $constraint */
        if (null === $value || '' === $value) {
            return;
        }
        if (!$this->voteRepository->exists($value)) {
            return;
        }

        $this->context
            ->buildViolation('Vote is not unique')
            ->addViolation();
    }
}
