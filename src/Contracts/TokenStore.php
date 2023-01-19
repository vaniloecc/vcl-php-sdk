<?php

declare(strict_types=1);

/**
 * Contains the TokenStore interface.
 *
 * @copyright   Copyright (c) 2023 Vanilo UG
 * @author      Attila Fulop
 * @license     MIT
 * @since       2023-01-18
 *
 */

namespace VaniloCloud\Contracts;

use VaniloCloud\Models\Credentials;

interface TokenStore
{
    public function hasAccessToken(): bool;

    public function getAccessToken(): ?string;

    public function saveAccessToken(string $token): void;

    public function hasRefreshToken(): bool;

    public function getRefreshToken(): ?string;

    public function saveRefreshToken(string $token): void;

    public function hasCredentials(): bool;

    public function getCredentials(): ?Credentials;

    public function saveCredentials(Credentials $credentials): void;
}
