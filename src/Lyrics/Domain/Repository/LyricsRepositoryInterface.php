<?php

declare(strict_types=1);

namespace App\Lyrics\Domain\Repository;

use App\Lyrics\Domain\Entity\Lyrics;
use App\Lyrics\Domain\Entity\LyricsId;
use App\Lyrics\Domain\Entity\SongId;
use App\Session\Domain\Entity\Session;

interface LyricsRepositoryInterface
{
    public function save(Lyrics $lyrics): void;
    public function getById(LyricsId $lyricsId): Lyrics;
    public function findBySongId(SongId $songId): ?Lyrics;
}
