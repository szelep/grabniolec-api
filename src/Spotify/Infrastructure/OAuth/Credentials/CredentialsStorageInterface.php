<?php

declare(strict_types=1);

namespace App\Spotify\Infrastructure\OAuth\Credentials;

interface CredentialsStorageInterface
{
    public function save(string $code, CredentialsInterface $credentials): void;
    public function get(string $code): ?CredentialsInterface;
}
