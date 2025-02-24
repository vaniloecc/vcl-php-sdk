<?php

declare(strict_types=1);

namespace VaniloCloud\Models;

class Province
{
    use HasDynamicAttributeConstructor;

    public readonly ?string $code;

    public readonly ?string $name;

    public readonly ?string $type;
}
