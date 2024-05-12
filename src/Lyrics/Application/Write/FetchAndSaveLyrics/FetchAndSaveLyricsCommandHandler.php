<?php

declare(strict_types=1);

namespace App\Lyrics\Application\Write\FetchAndSaveLyrics;

use App\Lyrics\Domain\Entity\LyricsText;
use App\Lyrics\Domain\Entity\SongId;
use App\Lyrics\Domain\Entity\Status;
use App\Lyrics\Domain\Repository\LyricsRepositoryInterface;
use App\SharedKernel\Application\Gateway\SpotifyGatewayInterface;
use Symfony\Component\BrowserKit\HttpBrowser;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class FetchAndSaveLyricsCommandHandler
{
    public function __construct(
        private SpotifyGatewayInterface $spotifyGateway,
        private LyricsRepositoryInterface $lyricsRepository
    ) {
    }

    public function __invoke(FetchAndSaveLyricsCommand $command)
    {
        $lyrics = $this->lyricsRepository->findBySongId(SongId::fromString($command->songId));
        if (Status::Queued !== $lyrics->getStatus()) {
            return;
        }

        $songDetails = $this->spotifyGateway->fetchSongDetailsById($command->songId);
        $scrapedLyricsText = $this->scrapLyrics($songDetails->fullTitle);
        $lyrics->setStatus(Status::NotFound);
        if (null !== $scrapedLyricsText) {
            $lyrics->setLyricsText(LyricsText::fromString($scrapedLyricsText));
            $lyrics->setStatus(Status::Downloaded);
        }

        $this->lyricsRepository->save($lyrics);
    }

    private function scrapLyrics(string $songTitle): ?string
    {
        try {
            $browser = new HttpBrowser(HttpClient::create());
            $crawler = $browser->request('GET', 'https://www.tekstowo.pl/');
            $form = $crawler->selectButton('Szukaj')->form();
            $form->setValues(['search-query' => $songTitle]);
            $searchPage = $browser->submit($form);
            $box = $searchPage->filter('.mb-4')->first()->filter('a')->first();

            $lyricsPage = $browser->request('GET', $box->first()->attr('href'));

            return $lyricsPage->filter("#songText")->filter('.inner-text')->html();
        } catch (\Throwable) {
            return null;
        }

    }
}
