<?php

namespace VaniloCloud\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class ArrayOf
{
    public function __construct(public string $type)
    {
    }
}
