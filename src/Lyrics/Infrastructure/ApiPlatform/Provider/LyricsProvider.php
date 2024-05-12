<?php

declare(strict_types=1);

namespace App\Lyrics\Infrastructure\ApiPlatform\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Lyrics\Application\Write\FetchAndSaveLyrics\FetchAndSaveLyricsCommand;
use App\Lyrics\Domain\Entity\Lyrics;
use App\Lyrics\Domain\Entity\LyricsId;
use App\Lyrics\Domain\Entity\LyricsText;
use App\Lyrics\Domain\Entity\SongId;
use App\Lyrics\Domain\Repository\LyricsRepositoryInterface;
use App\Lyrics\Infrastructure\Api\GetLyricsResponse;
use Symfony\Component\Messenger\MessageBusInterface;

final readonly class LyricsProvider implements ProviderInterface
{
    public function __construct(
        private LyricsRepositoryInterface $lyricsRepository,
        private MessageBusInterface $messageBus
    )
    {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): ?GetLyricsResponse
    {
        $songId = $uriVariables['songId'];
        $lyrics = $this->findInRepository($songId);
        if (null === $lyrics) {
            $lyrics = new Lyrics(
                LyricsId::generate(),
                LyricsText::fromString(''),
                SongId::fromString($songId)
            );
            $this->lyricsRepository->save($lyrics);
        }
        $this->messageBus->dispatch(new FetchAndSaveLyricsCommand($songId));

        return new GetLyricsResponse(
            (string) $lyrics->getId(),
            (string) $lyrics->getLyricsText(),
            $lyrics->getStatus()->value
        );
    }

    private function findInRepository(string $songId): ?Lyrics
    {
        return $this->lyricsRepository->findBySongId(SongId::fromString($songId));
    }
}
