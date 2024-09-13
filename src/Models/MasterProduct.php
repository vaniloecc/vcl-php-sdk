<?php

declare(strict_types=1);

namespace VaniloCloud\Models;

class MasterProduct
{
    use HasId;
    use HasTimestamps;
    use HasDynamicAttributeConstructor;

    public readonly string $name;

    public readonly ?string $slug;

    public readonly ?float $price;

    public readonly ?float $original_price;

    public readonly ?string $state;

    public readonly ?string $tax_category_id;

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

    public readonly ?array $variants;
}
