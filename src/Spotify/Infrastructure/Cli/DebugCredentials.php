<?php

declare(strict_types=1);

namespace App\Spotify\Infrastructure\Cli;

use App\Spotify\Infrastructure\Client\ClientInterface;
use Psr\Cache\CacheItemPoolInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @todo cron
 */
#[AsCommand('app:debug:credentials')]
final class DebugCredentials extends Command
{
    public function __construct(
        private CacheItemPoolInterface $cacheItemPool
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        dd($this->cacheItemPool->getItem('2bf706b8-438e-4af6-a46e-fb31cbeaa8b8')->get());

        return self::SUCCESS;
    }
}
