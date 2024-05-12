<?php

declare(strict_types=1);

namespace App\Vote\Infrastructure\ApiPlatform\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\SharedKernel\Infrastructure\Util\RequestStateHeaderRetriever;
use App\Vote\Domain\Entity\ClientId;
use App\Vote\Domain\Entity\SongId;
use App\Vote\Domain\Repository\VoteRepositoryInterface;
use App\Vote\Infrastructure\Api\Response\GetSongVotesResponse;

final readonly class SongVotesGetProvider implements ProviderInterface
{
    public function __construct(
        private RequestStateHeaderRetriever $headerRetriever,
        private VoteRepositoryInterface $voteRepository
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): GetSongVotesResponse
    {
        $songId = SongId::fromString($uriVariables['songId']);
        $clientId = $this->headerRetriever->getValue('X-CLIENT-ID');
        $counts = $this->voteRepository->getCountsBySongId($songId);
        $currentClientVote = $this->voteRepository->findBySongAndClient($songId, ClientId::fromString($clientId));

        return new GetSongVotesResponse(
            $counts->likes,
            $counts->dislikes,
            $currentClientVote?->getVoteResult()?->value
        );
    }
}
