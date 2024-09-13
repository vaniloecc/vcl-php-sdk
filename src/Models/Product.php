<?php

declare(strict_types=1);

namespace VaniloCloud\Models;

use VaniloCloud\Enums\ProductState;

class Product
{
    use HasId;
    use HasTimestamps;
    use HasDynamicAttributeConstructor;

    public readonly string $name;

    public readonly string $slug;

    public readonly string $sku;

    public readonly float $stock;

    public readonly ?float $backorder;

    public readonly ?float $price;

    public readonly ?float $original_price;

    public readonly ?ProductState $state;

    public readonly string $tax_category_id;

    public readonly ?string $description;

    public readonly ?string $short_description;

    public readonly ?float $weight;

    public readonly ?float $height;

    public readonly ?float $width;

    public readonly ?float $length;

    public readonly ?string $ext_title;

    public readonly ?string $meta_description;

    public readonly ?string $meta_keywords;

    public readonly ?array $custom_attributes;

    public readonly ?array $images;
}
