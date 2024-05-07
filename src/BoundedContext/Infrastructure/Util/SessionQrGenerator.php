<?php

declare(strict_types=1);

namespace App\BoundedContext\Infrastructure\Util;

use chillerlan\QRCode\QRCode;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;

final readonly class SessionQrGenerator
{
    public function __construct(
        private RouterInterface $router
    )
    {
    }

    public function generateForUuid(string $uuid): string
    {
        $url = $this->router->generate(
            'join-session',
            ['id' => $uuid],
            UrlGeneratorInterface::ABSOLUTE_PATH
        );

        return (new QRCode())->render($url);
    }
}
