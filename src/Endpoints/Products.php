<?php

declare(strict_types=1);

namespace VaniloCloud\Endpoints;

use Illuminate\Support\Collection;
use VaniloCloud\Models\Product;
use VaniloCloud\WriteModels\ProductCreate;
use VaniloCloud\WriteModels\ProductUpdate;

trait Products
{
    public function product(string $sku, bool $includeImages = false): ?Product
    {
        $url = "/products/$sku";
        if ($includeImages) {
            $url .= '?include=images';
        }

        $response = $this->get($url);
        if (!$response->successful()) {
            return null;
        }

        return new Product($this->transpose($response->json(), Product::class));
    }

    public function products(bool $includeImages = false): Collection
    {
        $url = "/products";
        if ($includeImages) {
            $url .= '?include=images';
        }

        $response = $this->get($url);

        $result = collect();
        if ($response->successful()) {
            foreach ($response->json('data') as $item) {
                /** @var Product $product */
                $product = new Product($this->transpose($item, Product::class));
                $result->put($product->id, $product);
            }
        }

        return $result;
    }

    /**
     * Returns the sku of the created product
     */
    public function createProduct(ProductCreate $product): ?string
    {
        $response = $this->post('/products', $product->toArray());

        if (201 !== $response->status()) {
            return null;
        }

        $urlParts = explode('/', $response->header('Location'));

        return end($urlParts);
    }

    public function updateProduct(string $sku, ProductUpdate $product): bool
    {
        $filteredProduct = array_filter($product->toArray(), static fn($value) => $value !== null);

        return 200 === $this->patch("/products/$sku", $filteredProduct)->status();
    }

    public function deleteProduct(string $sku): bool
    {
        return 204 === $this->delete("/products/$sku")->status();
    }
}
