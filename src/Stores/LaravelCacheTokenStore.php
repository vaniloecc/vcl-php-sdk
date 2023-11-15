<?php

declare(strict_types=1);

/**
 * Contains the LaravelCacheTokenStore class.
 *
 * @copyright   Copyright (c) 2023 Vanilo UG
 * @author      Attila Fulop
 * @license     MIT
 * @since       2023-11-13
 *
 */

namespace VaniloCloud\Stores;

use Illuminate\Support\Facades\Cache;
use VaniloCloud\Contracts\TokenStore;
use VaniloCloud\Models\Credentials;

class LaravelCacheTokenStore implements TokenStore
{
    public function __construct(
        private string $forUrl = 'default',
        private ?int $credentialsTtl = null,
        private ?int $accessTokenTtl = 90000, // 25 hours
        private ?int $refreshTokenTtl = 31708800, // 367 days
    ) {
        if (!class_exists(Cache::class)) {
            throw new \RuntimeException('The `Cache` facade is missing and is required to use the LaravelCacheTokenStore');
        }
    }

    public function hasAccessToken(): bool
    {
        return Cache::has($this->accessTokenKey());
    }

    public function getAccessToken(): ?string
    {
        return Cache::get($this->accessTokenKey()) ?: null;
    }

    public function saveAccessToken(string $token): void
    {
        Cache::put($this->accessTokenKey(), $token, $this->accessTokenTtl);
    }

    public function hasRefreshToken(): bool
    {
        return Cache::has($this->refreshTokenKey());
    }

    public function getRefreshToken(): ?string
    {
        return Cache::get($this->refreshTokenKey()) ?: null;
    }

    public function saveRefreshToken(string $token): void
    {
        Cache::put($this->refreshTokenKey(), $token, $this->refreshTokenTtl);
    }

    public function hasCredentials(): bool
    {
        return Cache::has($this->credentialsKey());
    }

    public function getCredentials(): ?Credentials
    {
        return Cache::get($this->credentialsKey()) ?: null;
    }

    public function saveCredentials(Credentials $credentials): void
    {
        Cache::set($this->credentialsKey(), $credentials, $this->credentialsTtl);
    }

    private function credentialsKey(): string
    {
        return md5($this->forUrl . '__credentials');
    }

    private function accessTokenKey(): string
    {
        return md5($this->forUrl . '__access_token');
    }

    private function refreshTokenKey(): string
    {
        return md5($this->forUrl . '__refresh_token');
    }
}
