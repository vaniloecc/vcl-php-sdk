<?php

declare(strict_types=1);

/**
 * Contains the HasDynamicAttributeConstructor trait.
 *
 * @copyright   Copyright (c) 2023 Vanilo UG
 * @author      Attila Fulop
 * @license     MIT
 * @since       2023-01-13
 *
 */

namespace VaniloCloud\Models;

trait HasDynamicAttributeConstructor
{
    public function __construct(array $attributes)
    {
        foreach ($attributes as $property => $value) {
            if (property_exists($this, $property)) {
                $this->{$property} = $value;
            }
        }
    }
}
