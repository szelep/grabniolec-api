<?php

declare(strict_types=1);

namespace App\Vote\Infrastructure\Validator;

use App\Vote\Domain\Entity\ClientId;
use App\Vote\Domain\Entity\SongId;
use App\Vote\Domain\Repository\VoteRepositoryInterface;
use App\Vote\Infrastructure\Api\Request\CreateVoteRequest;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

final class UniqueVoteValidator extends ConstraintValidator
{
    public function __construct(private VoteRepositoryInterface $voteRepository)
    {
    }

    /**
     * @param CreateVoteRequest $value
     */
    public function validate($value, Constraint $constraint)
    {
        /* @var UniqueVote $constraint */
        if (null === $value || '' === $value) {
            return;
        }
        if (null === $this->voteRepository->findBySongAndClient(
            SongId::fromString($value->songId),
            ClientId::fromString($value->clientId)
        )) {
            return;
        }

        $this->context
            ->buildViolation('Vote is not unique')
            ->addViolation();
    }
}
