<?php

declare(strict_types=1);

namespace VaniloCloud\WriteModels;

use VaniloCloud\Enums\ProductState;

class ProductCreate extends BaseWriteModel
{
    public function setName(string $name): self
    {
        $this->data['name'] = $name;

        return $this;
    }

    public function setSku(string $sku): self
    {
        $this->data['sku'] = $sku;

        return $this;
    }

    public function setSlug(?string $slug): self
    {
        $this->data['slug'] = $slug;

        return $this;
    }

    public function setStock(float $stock): self
    {
        $this->data['stock'] = $stock;

        return $this;
    }

    public function setBackorder(?float $backorder): self
    {
        $this->data['backorder'] = $backorder;

        return $this;
    }

    public function setPrice(?float $price): self
    {
        $this->data['price'] = $price;

        return $this;
    }

    public function setOriginalPrice(?float $original_price): self
    {
        $this->data['original_price'] = $original_price;

        return $this;
    }

    public function setState(ProductState $state): self
    {
        $this->data['state'] = $state;

        return $this;
    }

    public function setTaxCategoryId(?string $tax_category_id): self
    {
        $this->data['tax_category_id'] = $tax_category_id;

        return $this;
    }

    public function setDescription(?string $description): self
    {
        $this->data['description'] = $description;

        return $this;
    }

    public function setShortDescription(?string $short_description): self
    {
        $this->data['short_description'] = $short_description;

        return $this;
    }

    public function setWeight(?float $weight): self
    {
        $this->data['weight'] = $weight;

        return $this;
    }

    public function setHeight(?float $height): self
    {
        $this->data['height'] = $height;

        return $this;
    }

    public function setWidth(?float $width): self
    {
        $this->data['width'] = $width;

        return $this;
    }

    public function setLength(?float $length): self
    {
        $this->data['length'] = $length;

        return $this;
    }

    public function setExtTitle(?string $ext_title): self
    {
        $this->data['ext_title'] = $ext_title;

        return $this;
    }

    public function setMetaDescription(?string $meta_description): self
    {
        $this->data['meta_description'] = $meta_description;

        return $this;
    }

    public function setMetaKeywords(?string $meta_keywords): self
    {
        $this->data['meta_keywords'] = $meta_keywords;

        return $this;
    }

    public function setCustomAttributes(?array $custom_attributes): self
    {
        $this->data['custom_attributes'] = $custom_attributes;

        return $this;
    }

    public function setTaxons(array $taxons): self
    {
        $this->data['taxons'] = $taxons;

        return $this;
    }

    public function setProperties(array $properties): self
    {
        $this->data['properties'] = $properties;

        return $this;
    }
}
