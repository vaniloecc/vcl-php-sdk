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

    public function setProductId(?string $productId): self
    {
        $this->data['product_id'] = $productId;

        return $this;
    }

    public function setProductType(?ProductType $productType): self
    {
        $this->data['product_type'] = $productType;

        return $this;
    }

    public function setPrice(float $price): self
    {
        $this->data['price'] = $price;

        return $this;
    }

    public function setOriginalPrice(?float $originalPrice): self
    {
        $this->data['original_price'] = $originalPrice;

        return $this;
    }

    public function setQuantity(?int $quantity): self
    {
        $this->data['quantity'] = $quantity;

        return $this;
    }

    public function setInstructions(array $instructions): self
    {
        $this->data['__instructions'] = $instructions;

        return $this;
    }
}
