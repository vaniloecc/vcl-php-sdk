<?php

declare(strict_types=1);

namespace VaniloCloud\Endpoints;

use Illuminate\Support\Collection;
use VaniloCloud\Models\Address;
use VaniloCloud\WriteModels\AddressUpdate;
use VaniloCloud\WriteModels\ProductCreate;

trait Addresses
{
    /**
     * Get an address by id.
     *
     * @param string|int $id The address id.
     * @return Address|null The address or null if not found.
     */
    public function address(string|int $id): ?Address
    {
        $url = "/addresses/$id";

        $response = $this->get($url);
        if (!$response->successful()) {
            return null;
        }

        return new Address($this->transpose($response->json(), Address::class));
    }

    /**
     * Get all products with optional includes.
     *
     * @param array $includes Optional data to include.
     * @return Collection A collection of Product objects.
     */
    /*public function products(array $includes = []): Collection
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
    }*/

    /**
     * Create a new product.
     *
     * @param ProductCreate $product The product data to create.
     * @return string|null The ID of the created product, or null on failure.
     */
    /*public function createProduct(ProductCreate $product): ?string
    {
        $response = $this->post('/products', $product->toArray());

        if (201 !== $response->status()) {
            return null;
        }

        $urlParts = explode('/', $response->header('Location'));

        return end($urlParts);
    }*/

    /**
     * Update an existing address by id.
     *
     * @param string|int $id The id of the address to update.
     * @param AddressUpdate $address The updated address data.
     * @return bool True if the update was successful, false otherwise.
     */
    public function updateAddress(string|int $id, AddressUpdate $address): bool
    {
        return 200 === $this->patch("/addresses/$id", $address->toArray())->status();
    }

    /**
     * Delete an address by id.
     *
     * @param string|int $id The id of the address to delete.
     * @return bool True if the deletion was successful, false otherwise.
     */
    public function deleteAddress(string|int $id): bool
    {
        return 204 === $this->delete("/addresses/$id")->status();
    }
}
