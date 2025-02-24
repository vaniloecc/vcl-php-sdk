<?php

declare(strict_types=1);

namespace VaniloCloud\Models;

class ShippingMethod
{
    use HasId;
    use HasDynamicAttributeConstructor;

    public readonly ?string $name;

    public readonly bool $is_active;

    public readonly ?string $calculator;

    public readonly ?array $configuration;

    public readonly ?Carrier $carrier;

    public readonly ?Zone $zone;
}
