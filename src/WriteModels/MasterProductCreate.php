<?php

declare(strict_types=1);

namespace VaniloCloud\WriteModels;

use VaniloCloud\Enums\ProductState;

class MasterProductCreate extends BaseWriteModel
{
    public function setName(string $name): self
    {
        $this->data['name'] = $name;

        return $this;
    }

    public function setSlug(?string $slug): self
    {
        $this->data['slug'] = $slug;

        return $this;
    }

    public function setPrice(?float $price): self
    {
        $this->data['price'] = $price;

        return $this;
    }

    public function setOriginalPrice(?float $originalPrice): self
    {
        $this->data['original_price'] = $originalPrice;

        return $this;
    }

    public function setState(ProductState $state): self
    {
        $this->data['state'] = $state;

        return $this;
    }

    public function setTaxCategoryId(?string $taxCategoryId): self
    {
        $this->data['tax_category_id'] = $taxCategoryId;

        return $this;
    }

    public function setDescription(?string $description): self
    {
        $this->data['description'] = $description;

        return $this;
    }

    public function setShortDescription(?string $shortDescription): self
    {
        $this->data['short_description'] = $shortDescription;

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

    public function setExtTitle(?string $extTitle): self
    {
        $this->data['ext_title'] = $extTitle;

        return $this;
    }

    public function setMetaDescription(?string $metaDescription): self
    {
        $this->data['meta_description'] = $metaDescription;

        return $this;
    }

    public function setMetaKeywords(?string $metaKeywords): self
    {
        $this->data['meta_keywords'] = $metaKeywords;

        return $this;
    }

    public function setCustomAttributes(?array $customAttributes): self
    {
        $this->data['custom_attributes'] = $customAttributes;

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
