<?php

declare(strict_types=1);

namespace VaniloCloud\Endpoints;

use VaniloCloud\Models\Address;
use VaniloCloud\WriteModels\AddressUpdate;

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
