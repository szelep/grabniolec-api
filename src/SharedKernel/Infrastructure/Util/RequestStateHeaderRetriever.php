<?php

declare(strict_types=1);

namespace App\SharedKernel\Infrastructure\Util;

use App\SharedKernel\Domain\Exception\HeaderRequiredException;
use Symfony\Component\HttpFoundation\RequestStack;

final readonly class RequestStateHeaderRetriever
{
    public function __construct(private RequestStack $requestStack)
    {
    }

    public function getValue(string $header): string
    {
        return $this
            ->requestStack
            ->getCurrentRequest()
            ->headers
            ->get($header) ?? throw HeaderRequiredException::withHeaderName($header)
        ;
    }
}
