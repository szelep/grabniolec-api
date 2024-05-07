<?php

declare(strict_types=1);

namespace App\Spotify\Infrastructure\Cli;

use App\Spotify\Infrastructure\Client\ClientInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @todo cron
 */
#[AsCommand('app:spotify:refresh-token')]
final class RefreshTokenCliCommand extends Command
{
    public function __construct(
        private ClientInterface $client
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->client->refreshToken();

        return self::SUCCESS;
    }
}
