<?php

declare(strict_types=1);

namespace VaniloCloud\WriteModels;

use VaniloCloud\Enums\ProductState;

class ProductUpdate extends BaseWriteModel
{
    public ?string $name;
    public ?string $slug;
    public ?float $stock;
    public ?float $backorder;
    public ?float $price;
    public ?float $original_price;
    public ?ProductState $state;
    public ?string $tax_category_id;
    public ?string $description;
    public ?string $short_description;
    public ?float $weight;
    public ?float $height;
    public ?float $width;
    public ?float $length;
    public ?string $ext_title;
    public ?string $meta_description;
    public ?string $meta_keywords;
    public ?array $custom_attributes;
    public ?array $taxons;
    public ?array $properties;

    public function __construct(
        ?string      $name = null,
        ?string      $slug = null,
        ?float       $stock = null,
        ?float       $backorder = null,
        ?float       $price = null,
        ?float       $original_price = null,
        ProductState $state = null,
        ?string      $tax_category_id = null,
        ?string      $description = null,
        ?string      $short_description = null,
        ?float       $weight = null,
        ?float       $height = null,
        ?float       $width = null,
        ?float       $length = null,
        ?string      $ext_title = null,
        ?string      $meta_description = null,
        ?string      $meta_keywords = null,
        ?array       $custom_attributes = null,
        ?array       $taxons = null,
        ?array       $properties = null,
    )
    {
        $this->name = $name;
        $this->slug = $slug;
        $this->stock = $stock;
        $this->backorder = $backorder;
        $this->price = $price;
        $this->original_price = $original_price;
        $this->state = $state;
        $this->tax_category_id = $tax_category_id;
        $this->description = $description;
        $this->short_description = $short_description;
        $this->weight = $weight;
        $this->height = $height;
        $this->width = $width;
        $this->length = $length;
        $this->ext_title = $ext_title;
        $this->meta_description = $meta_description;
        $this->meta_keywords = $meta_keywords;
        $this->custom_attributes = $custom_attributes;
        $this->taxons = $taxons;
        $this->properties = $properties;
    }
}
