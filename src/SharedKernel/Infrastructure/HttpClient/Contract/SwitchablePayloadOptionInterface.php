<?php

declare(strict_types=1);

namespace App\SharedKernel\Infrastructure\HttpClient\Contract;

/**
 * @see https://symfony.com/doc/current/http_client.html#uploading-data
 */
interface SwitchablePayloadOptionInterface
{
    public const BODY = 'body';
    public const JSON = 'json';

    /**
     * Option used for data upload.
     *
     * Might be one of this interface constants.
     */
    public function getPayloadOptionKey(): string;
}
