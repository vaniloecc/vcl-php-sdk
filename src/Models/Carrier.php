<?php

declare(strict_types=1);

namespace VaniloCloud\Models;

class Carrier
{
    use HasDynamicAttributeConstructor;

    public readonly ?string $name;

    public readonly bool $is_active;

    public readonly ?array $configuration;
}
