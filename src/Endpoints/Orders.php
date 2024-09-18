<?php

declare(strict_types=1);

namespace VaniloCloud\Endpoints;

use Illuminate\Support\Collection;
use VaniloCloud\Models\Order;
use VaniloCloud\WriteModels\OrderCreate;
use VaniloCloud\WriteModels\OrderUpdate;

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
                $order = new Order($this->transpose($item, Order::class));

                $result->put($order->id, $order);
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

        if (201 !== $response->status()) {
            return null;
        }

        $urlParts = explode('/', $response->header('Location'));

        return end($urlParts);
    }

    /**
     * Update an existing order by id.
     *
     * @param string|int $id The id of the order to update.
     * @param OrderUpdate $orderUpdate The updated order data.
     * @return bool True if the update was successful, false otherwise.
     */
    public function updateOrder(string|int $id, OrderUpdate $orderUpdate): bool
    {
        return 200 === $this->patch("/orders/$id", $orderUpdate->toArray())->status();
    }

    /**
     * Delete an order by id.
     *
     * @param string|int $id The id of the order to delete.
     * @return bool True if the deletion was successful, false otherwise.
     */
    public function deleteOrder(string|int $id): bool
    {
        return 204 === $this->delete("/orders/$id")->status();
    }
}
