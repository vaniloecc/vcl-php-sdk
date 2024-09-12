<?php

declare(strict_types=1);

namespace VaniloCloud\Endpoints;

use Illuminate\Support\Collection;
use VaniloCloud\Models\MasterProduct;
use VaniloCloud\WriteModels\MasterProductCreate;
use VaniloCloud\WriteModels\MasterProductUpdate;

trait MasterProducts
{
    /**
     * Get a master product by id with optional includes.
     *
     * @param string|int $id The product id.
     * @param array $includes Optional data to include.
     * @return MasterProduct|null The product or null if not found.
     */
    public function masterProduct(string|int $id, array $includes = []): ?MasterProduct
    {
        $url = "/master-products/$id";

        if (!empty($includes)) {
            $url .= '?include=' . implode(',', $includes);
        }

        $response = $this->get($url);
        if (!$response->successful()) {
            return null;
        }

        return new MasterProduct($this->transpose($response->json(), MasterProduct::class));
    }

    /**
     * Get all master products with optional includes.
     *
     * @param array $includes Optional data to include.
     * @return Collection A collection of MasterProduct objects.
     */
    public function masterProducts(array $includes = []): Collection
    {
        $url = "/master-products";

        if (!empty($includes)) {
            $url .= '?include=' . implode(',', $includes);
        }

        $response = $this->get($url);

        $result = collect();
        if ($response->successful()) {
            foreach ($response->json('data') as $item) {
                $masterProduct = new MasterProduct($this->transpose($item, MasterProduct::class));

                $result->put($masterProduct->id, $masterProduct);
            }
        }

        return $result;
    }

    /**
     * Create a new master product.
     *
     * @param MasterProductCreate $masterProductCreate The master product data to create.
     * @return string|null The ID of the created master product, or null on failure.
     */
    public function createMasterProduct(MasterProductCreate $masterProductCreate): ?string
    {
        $response = $this->post('/master-products', $masterProductCreate->toArray());

        if (201 !== $response->status()) {
            return null;
        }

        $urlParts = explode('/', $response->header('Location'));

        return end($urlParts);
    }

    /**
     * Update an existing master product by id.
     *
     * @param string|int $id The id of the master product to update.
     * @param MasterProductUpdate $masterProductUpdate The updated master product data.
     * @return bool True if the update was successful, false otherwise.
     */
    public function updateMasterProduct(string|int $id, MasterProductUpdate $masterProductUpdate): bool
    {
        return 200 === $this->patch("/master-products/$id", $masterProductUpdate->toArray())->status();
    }

    /**
     * Delete a master product by id.
     *
     * @param string|int $id The id of the master product to delete.
     * @return bool True if the deletion was successful, false otherwise.
     */
    public function deleteMasterProduct(string|int $id): bool
    {
        return 204 === $this->delete("/master-products/$id")->status();
    }
}
