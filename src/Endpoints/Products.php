<?php

declare(strict_types=1);

namespace VaniloCloud\Endpoints;

use Illuminate\Support\Collection;
use VaniloCloud\Models\Product;
use VaniloCloud\WriteModels\ProductCreate;
use VaniloCloud\WriteModels\ProductUpdate;

trait Products
{
    /**
     * Get a product by SKU with optional includes.
     *
     * @param string $sku The product SKU.
     * @param array $includes Optional data to include.
     * @return Product|null The product or null if not found.
     */
    public function product(string $sku, array $includes = []): ?Product
    {
        $url = "/products/$sku";

        if (!empty($includes)) {
            $url .= '?include=' . implode(',', $includes);
        }

        $response = $this->get($url);
        if (!$response->successful()) {
            return null;
        }

        return new Product($this->transpose($response->json(), Product::class));
    }

    /**
     * Get all products with optional includes.
     *
     * @param array $includes Optional data to include.
     * @return Collection A collection of Product objects.
     */
    public function products(array $includes = []): Collection
    {
        $url = "/products";

        if (!empty($includes)) {
            $url .= '?include=' . implode(',', $includes);
        }

        $response = $this->get($url);

        $result = collect();
        if ($response->successful()) {
            foreach ($response->json('data') as $item) {
                $product = new Product($this->transpose($item, Product::class));

                $result->put($product->id, $product);
            }
        }

        return $result;
    }

    /**
     * Create a new product.
     *
     * @param ProductCreate $product The product data to create.
     * @return string|null The ID of the created product, or null on failure.
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

    /**
     * Update an existing product by SKU.
     *
     * @param string $sku The SKU of the product to update.
     * @param ProductUpdate $product The updated product data.
     * @return bool True if the update was successful, false otherwise.
     */
    public function updateProduct(string $sku, ProductUpdate $product): bool
    {
        return 200 === $this->patch("/products/$sku", $product->toArray())->status();
    }

    /**
     * Delete a product by SKU.
     *
     * @param string $sku The SKU of the product to delete.
     * @return bool True if the deletion was successful, false otherwise.
     */
    public function deleteProduct(string $sku): bool
    {
        return 204 === $this->delete("/products/$sku")->status();
    }
}
