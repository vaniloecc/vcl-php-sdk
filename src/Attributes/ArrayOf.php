<?php

declare(strict_types=1);

namespace VaniloCloud\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class ArrayOf
{
    public function __construct(public string $type)
    {
    }
}
