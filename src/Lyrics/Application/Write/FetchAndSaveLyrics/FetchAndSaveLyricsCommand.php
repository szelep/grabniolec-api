<?php

declare(strict_types=1);

namespace App\Lyrics\Application\Write\FetchAndSaveLyrics;

final readonly class FetchAndSaveLyricsCommand
{
    public function __construct(public string $songId)
    {
    }
}
