<?php

declare(strict_types=1);

namespace App\Spotify\Infrastructure\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Spotify\Infrastructure\Client\ClientInterface;
use App\Spotify\Infrastructure\Client\ValueObject\Device as DeviceVO;
use App\Spotify\Infrastructure\Response\Device;
use Symfony\Component\HttpFoundation\RequestStack;

final readonly class DevicesProvider implements ProviderInterface
{
    public function __construct(
        private ClientInterface $client
    ) {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $fetchedDevices = $this->client->fetchDevices();

        return array_map(fn (DeviceVO $device): Device => new Device(
            $device->id,
            $device->name,
            $device->type,
            (string) $device->volumePercent
        ), $fetchedDevices);
    }
}
