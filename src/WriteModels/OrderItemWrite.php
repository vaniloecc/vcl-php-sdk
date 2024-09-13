<?php

declare(strict_types=1);

namespace VaniloCloud\WriteModels;

use VaniloCloud\Enums\ProductType;

class OrderItemWrite extends BaseWriteModel
{
    public function setName(string $name): self
    {
        $this->data['name'] = $name;

        return $this;
    }

    public function setSku(?string $sku): self
    {
        $this->data['sku'] = $sku;

        return $this;
    }

    public function setProductId(?string $product_id): self
    {
        $this->data['product_id'] = $product_id;

        return $this;
    }

    public function setProductType(ProductType $product_type): self
    {
        $this->data['product_type'] = $product_type;

        return $this;
    }

    public function setPrice(float $price): self
    {
        $this->data['price'] = $price;

        return $this;
    }

    public function setOriginalPrice(?float $original_price): self
    {
        $this->data['original_price'] = $original_price;

        return $this;
    }

    public function setQuantity(?int $quantity): self
    {
        $this->data['quantity'] = $quantity;

        return $this;
    }

    public function set__Instructions(array $__instructions): self
    {
        $this->data['__instructions'] = $__instructions;

        return $this;
    }
}
