<?php

declare(strict_types=1);

namespace App\Lyrics\Domain\Entity;

use App\Lyrics\Domain\Repository\LyricsRepositoryInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LyricsRepositoryInterface::class)]
#[ORM\Table(
    name: 'lyrics',
    schema: 'lyrics'
)]
class Lyrics
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    private string $id;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private \DateTimeImmutable $createdAt;

    #[ORM\Column(type: Types::TEXT, unique: true)]
    private string $songId;

    #[ORM\Column(type: Types::TEXT)]
    private string $lyricsText;

    #[ORM\Column(enumType: Status::class)]
    private Status $status;

    public function __construct(LyricsId $id, LyricsText $text, SongId $songId)
    {
        $this->id = (string) $id;
        $this->createdAt = new \DateTimeImmutable();
        $this->lyricsText = (string) $text;
        $this->songId = (string) $songId;
        $this->status = Status::Queued;
    }

    public function getId(): LyricsId
    {
        return LyricsId::fromString($this->id);
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getLyricsText(): LyricsText
    {
        return LyricsText::fromString($this->lyricsText);
    }

    public function setLyricsText(LyricsText $lyricsText): void
    {
        $this->lyricsText = (string) $lyricsText;
    }

    public function getSongId(): SongId
    {
        return SongId::fromString($this->songId);
    }

    public function setSongId(SongId $songId): void
    {
        $this->songId = (string) $songId;
    }

    public function getStatus(): Status
    {
        return $this->status;
    }

    public function setStatus(Status $status): void
    {
        $this->status = $status;
    }

}
