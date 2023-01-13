<?php

declare(strict_types=1);

/**
 * Contains the Taxonomy class.
 *
 * @copyright   Copyright (c) 2023 Vanilo UG
 * @author      Attila Fulop
 * @license     MIT
 * @since       2023-01-13
 *
 */

namespace VaniloCloud\Models;

class Taxonomy
{
    use HasId;
    use HasTimestamps;
    use HasDynamicAttributeConstructor;

    public readonly string $name;
    public readonly ?string $slug;
}
