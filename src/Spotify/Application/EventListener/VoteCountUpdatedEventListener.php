<?php

declare(strict_types=1);

namespace App\Spotify\Application\EventListener;

use App\SharedKernel\Application\Event\VoteCountUpdatedEvent;
use App\Spotify\Infrastructure\HttpClient\Spotify\ClientInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener(VoteCountUpdatedEvent::class, method: 'onVoteCountUpdated')]
final readonly class VoteCountUpdatedEventListener
{
    private const int MIN_DISLIKES_COUNT_TO_SKIP_TRACK = 3;
    public function __construct(private ClientInterface $client)
    {
    }

    public function onVoteCountUpdated(VoteCountUpdatedEvent $event): void
    {
        $currentPlayback = $this->client->fetchCurrentPlayback($event->causedByClient);
        if (
            $event->dislikesCount >= self::MIN_DISLIKES_COUNT_TO_SKIP_TRACK
            && $currentPlayback->songId === $event->trackId
        ) {
            $this->client->skipTrack(
                $event->causedByClient,
                $currentPlayback->deviceId
            );
        }
    }
}
