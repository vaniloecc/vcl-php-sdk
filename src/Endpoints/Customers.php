<?php

declare(strict_types=1);

namespace VaniloCloud\Endpoints;

use Illuminate\Support\Collection;
use VaniloCloud\Models\Customer;
use VaniloCloud\WriteModels\CustomerCreate;
use VaniloCloud\WriteModels\CustomerUpdate;

trait Customers
{
    /**
     * Get a customer by id with optional includes.
     *
     * @param string|int $id The customer id.
     * @param array $includes Optional data to include.
     * @return Customer|null The customer or null if not found.
     */
    public function customer(string|int $id, array $includes = []): ?Customer
    {
        $url = "/customers/$id";

        if (!empty($includes)) {
            $url .= '?include=' . implode(',', $includes);
        }

        $response = $this->get($url);
        if (!$response->successful()) {
            return null;
        }

        return new Customer($this->transpose($response->json(), Customer::class));
    }

    /**
     * Get all customers with optional includes.
     *
     * @param array $includes Optional data to include.
     * @return Collection A collection of Customer objects.
     */
    public function customers(array $includes = []): Collection
    {
        $url = "/customers";

        if (!empty($includes)) {
            $url .= '?include=' . implode(',', $includes);
        }

        $response = $this->get($url);

        $result = collect();
        if ($response->successful()) {
            foreach ($response->json('data') as $item) {
                $customer = new Customer($this->transpose($item, Customer::class));

                $result->put($customer->id, $customer);
            }
        }

        return $result;
    }

    /**
     * Create a new customer.
     *
     * @param CustomerCreate $customer The customer data to create.
     * @return string|null The ID of the created customer, or null on failure.
     */
    public function createCustomer(CustomerCreate $customer): ?string
    {
        $response = $this->post('/customers', $customer->toArray());

        if (201 !== $response->status()) {
            return null;
        }

        $urlParts = explode('/', $response->header('Location'));

        return end($urlParts);
    }

    /**
     * Update an existing customer by id.
     *
     * @param string|int $id The id of the customer to update.
     * @param CustomerUpdate $customer The updated customer data.
     * @return bool True if the update was successful, false otherwise.
     */
    public function updateCustomer(string|int $id, CustomerUpdate $customer): bool
    {
        return 200 === $this->patch("/customers/$id", $customer->toArray())->status();
    }

    /**
     * Delete a customer by SKU.
     *
     * @param string|int $id The id of the customer to delete.
     * @return bool True if the deletion was successful, false otherwise.
     */
    public function deleteCustomer(string|int $id): bool
    {
        return 204 === $this->delete("/customers/$id")->status();
    }
}
