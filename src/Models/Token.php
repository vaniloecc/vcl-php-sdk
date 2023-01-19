<?php

declare(strict_types=1);

/**
 * Contains the Token class.
 *
 * @copyright   Copyright (c) 2023 Vanilo UG
 * @author      Attila Fulop
 * @license     MIT
 * @since       2023-01-18
 *
 */

namespace VaniloCloud\Models;

final class Token
{
    public function __construct(
        public readonly string $accessToken,
        public readonly int $expiryInSeconds,
        public readonly ?string $refreshToken = null,
    ) {
    }
}
