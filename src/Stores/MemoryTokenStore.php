<?php

declare(strict_types=1);

/**
 * Contains the MemoryTokenStore class.
 *
 * @copyright   Copyright (c) 2023 Vanilo UG
 * @author      Attila Fulop
 * @license     MIT
 * @since       2023-01-18
 *
 */

namespace VaniloCloud\Stores;

use VaniloCloud\Contracts\TokenStore;
use VaniloCloud\Models\Credentials;

class MemoryTokenStore implements TokenStore
{
    private ?string $accessToken = null;

    private ?string $refreshToken = null;

    private ?Credentials $credentials = null;

    public function hasAccessToken(): bool
    {
        return null !== $this->accessToken;
    }

    public function getAccessToken(): ?string
    {
        return $this->accessToken;
    }

    public function saveAccessToken(string $token): void
    {
        $this->accessToken = $token;
    }

    public function hasRefreshToken(): bool
    {
        return null !== $this->refreshToken;
    }

    public function getRefreshToken(): ?string
    {
        return $this->refreshToken;
    }

    public function saveRefreshToken(string $token): void
    {
        $this->refreshToken = $token;
    }

    public function hasCredentials(): bool
    {
        return null !== $this->credentials;
    }

    public function getCredentials(): ?Credentials
    {
        return $this->credentials;
    }

    public function saveCredentials(Credentials $credentials): void
    {
        $this->credentials = $credentials;
    }
}
