<?php

declare(strict_types=1);

namespace VaniloCloud\Endpoints;

use Illuminate\Support\Collection;
use VaniloCloud\Models\Order;
use VaniloCloud\WriteModels\OrderCreate;

trait Orders
{
    /**
     * Get an order by id with optional includes.
     *
     * @param string|int $id The order id.
     * @param array $includes Optional data to include.
     * @return Order|null The order or null if not found.
     */
    public function order(string|int $id, array $includes = []): ?Order
    {
        $url = "/orders/$id";

        if (!empty($includes)) {
            $url .= '?include=' . implode(',', $includes);
        }

        $response = $this->get($url);
        if (!$response->successful()) {
            return null;
        }

        return new Order($this->transpose($response->json(), Order::class));
    }

    /**
     * Get all orders with optional includes.
     *
     * @param array $includes Optional data to include.
     * @return Collection A collection of Order objects.
     */
    public function orders(array $includes = []): Collection
    {
        $url = "/orders";

        if (!empty($includes)) {
            $url .= '?include=' . implode(',', $includes);
        }

        $response = $this->get($url);

        $result = collect();
        if ($response->successful()) {
            foreach ($response->json('data') as $item) {
                $masterProduct = new Order($this->transpose($item, Order::class));

                $result->put($masterProduct->id, $masterProduct);
            }
        }

        return $result;
    }

    /**
     * Create a new order.
     *
     * @param OrderCreate $orderCreate The order data to create.
     * @return string|null The ID of the created order, or null on failure.
     */
    public function createOrder(OrderCreate $orderCreate): ?string
    {
        $response = $this->post('/orders', $orderCreate->toArray());
dd($orderCreate->toArray(), $response->json(), $response);
        if (201 !== $response->status()) {
            return null;
        }

        $urlParts = explode('/', $response->header('Location'));

        return end($urlParts);
    }
//
//    /**
//     * Update an existing master product by id.
//     *
//     * @param string|int $id The id of the master product to update.
//     * @param MasterProductUpdate $masterProductUpdate The updated master product data.
//     * @return bool True if the update was successful, false otherwise.
//     */
//    public function updateMasterProduct(string|int $id, MasterProductUpdate $masterProductUpdate): bool
//    {
//        return 200 === $this->patch("/master-products/$id", $masterProductUpdate->toArray())->status();
//    }
//
//    /**
//     * Delete a master product by id.
//     *
//     * @param string|int $id The id of the master product to delete.
//     * @return bool True if the deletion was successful, false otherwise.
//     */
//    public function deleteMasterProduct(string|int $id): bool
//    {
//        return 204 === $this->delete("/master-products/$id")->status();
//    }
}
