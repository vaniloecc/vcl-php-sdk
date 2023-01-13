<?php

declare(strict_types=1);

/**
 * Contains the HasTimestamps trait.
 *
 * @copyright   Copyright (c) 2023 Vanilo UG
 * @author      Attila Fulop
 * @license     MIT
 * @since       2023-01-13
 *
 */

namespace VaniloCloud\Models;

use Carbon\CarbonImmutable;

trait HasTimestamps
{
    public readonly CarbonImmutable $created_at;

    public readonly CarbonImmutable $updated_at;
}
