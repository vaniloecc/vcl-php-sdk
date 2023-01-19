<?php

declare(strict_types=1);

/**
 * Contains the Credentials class.
 *
 * @copyright   Copyright (c) 2023 Vanilo UG
 * @author      Attila Fulop
 * @license     MIT
 * @since       2023-01-18
 *
 */

namespace VaniloCloud\Models;

use InvalidArgumentException;

final class Credentials
{
    public function __construct(
        public readonly string $clientId,
        public readonly string $clientSecret,
    ) {
    }

    /** @param array{client_id: string, client_secret: string} $credentials */
    public static function make(array $credentials): Credentials
    {
        if (!array_key_exists('client_id', $credentials)) {
            throw new InvalidArgumentException('The credentials array has no `client_id` field');
        } elseif (!is_string($credentials['client_id'])) {
            throw new InvalidArgumentException('The `client_id` field must be a string in the credentials array');
        } elseif (!array_key_exists('client_secret', $credentials)) {
            throw new InvalidArgumentException('The credentials array has no `client_secret` field');
        } elseif (!is_string($credentials['client_secret'])) {
            throw new InvalidArgumentException('The `client_secret` field must be a string in the credentials array');
        }

        return new self($credentials['client_id'], $credentials['client_secret']);
    }

    /** @return array{client_id: string, client_secret: string} */
    public function toArray(): array
    {
        return [
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
        ];
    }
}
