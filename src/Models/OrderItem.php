<?php

declare(strict_types=1);

namespace VaniloCloud\Models;

class OrderItem
{
    use HasId;
    use HasTimestamps;
    use HasDynamicAttributeConstructor;

    public readonly string $product_type;

    public readonly ?string $sku;

    public readonly ?string $name;

    public readonly int $quantity;

    public readonly float $price;

    public readonly ?array $configuration;
}
