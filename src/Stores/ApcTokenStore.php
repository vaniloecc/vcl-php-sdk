<?php

declare(strict_types=1);

/**
 * Contains the ApcTokenStore class.
 *
 * @copyright   Copyright (c) 2023 Vanilo UG
 * @author      Attila Fulop
 * @license     MIT
 * @since       2023-01-31
 *
 */

namespace VaniloCloud\Stores;

use VaniloCloud\Contracts\TokenStore;
use VaniloCloud\Models\Credentials;

class ApcTokenStore implements TokenStore
{
    public function __construct(
        private string $forUrl = 'default',
        private ?int $credentialsTtl = null,
        private ?int $accessTokenTtl = 90000, // 25 hours
        private ?int $refreshTokenTtl = 31708800, // 367 days
    ) {
        if (!extension_loaded('apcu')) {
            throw new \RuntimeException('The `apcu` extension is missing and is required to use the ApcTokenStore');
        } elseif (!apcu_enabled()) {
            throw new \RuntimeException('The `apcu` extension is not enable but is required to use the ApcTokenStore');
        }
    }

    public function hasAccessToken(): bool
    {
        return apcu_exists($this->accessTokenKey());
    }

    public function getAccessToken(): ?string
    {
        return apcu_fetch($this->accessTokenKey()) ?: null;
    }

    public function saveAccessToken(string $token): void
    {
        apcu_store($this->accessTokenKey(), $token, $this->accessTokenTtl);
    }

    public function hasRefreshToken(): bool
    {
        return apcu_exists($this->refreshTokenKey());
    }

    public function getRefreshToken(): ?string
    {
        return apcu_fetch($this->refreshTokenKey()) ?: null;
    }

    public function saveRefreshToken(string $token): void
    {
        apcu_store($this->refreshTokenKey(), $token, $this->refreshTokenTtl);
    }

    public function hasCredentials(): bool
    {
        return apcu_exists($this->credentialsKey());
    }

    public function getCredentials(): ?Credentials
    {
        return apcu_fetch($this->credentialsKey()) ?: null;
    }

    public function saveCredentials(Credentials $credentials): void
    {
        apcu_store($this->credentialsKey(), $credentials, $this->credentialsTtl);
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
