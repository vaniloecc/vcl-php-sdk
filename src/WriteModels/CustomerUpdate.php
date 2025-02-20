<?php

declare(strict_types=1);

namespace VaniloCloud\WriteModels;

use VaniloCloud\Enums\CustomerType;

class CustomerUpdate extends BaseWriteModel
{
    public function setDefaultShippingAddressId(?string $defaultShippingAddressId): self
    {
        $this->data['default_shipping_address_id'] = $defaultShippingAddressId;

        return $this;
    }

    public function setDefaultBillingAddressId(?string $defaultBillingAddressId): self
    {
        $this->data['default_billing_address_id'] = $defaultBillingAddressId;

        return $this;
    }

    public function setType(?CustomerType $type): self
    {
        $this->data['type'] = $type;

        return $this;
    }

    public function setFirstname(?string $firstname): self
    {
        $this->data['firstname'] = $firstname;

        return $this;
    }

    public function setLastname(?string $lastname): self
    {
        $this->data['lastname'] = $lastname;

        return $this;
    }

    public function setCompanyName(?string $companyName): self
    {
        $this->data['company_name'] = $companyName;

        return $this;
    }

    public function setTaxNr(?string $taxNr): self
    {
        $this->data['tax_nr'] = $taxNr;

        return $this;
    }

    public function setRegistrationNr(?string $registrationNr): self
    {
        $this->data['registration_nr'] = $registrationNr;

        return $this;
    }

    public function setEmail(?string $email): self
    {
        $this->data['email'] = $email;

        return $this;
    }

    public function setPhone(?string $phone): self
    {
        $this->data['phone'] = $phone;

        return $this;
    }

    public function setIsActive(?bool $isActive): self
    {
        $this->data['is_active'] = $isActive;

        return $this;
    }

    public function setTimezone(?string $timezone): self
    {
        $this->data['timezone'] = $timezone;

        return $this;
    }

    public function setLastPurchaseAt(?string $lastPurchaseAt): self
    {
        $this->data['last_purchase_at'] = $lastPurchaseAt;

        return $this;
    }

    public function setLtv(?float $ltv): self
    {
        $this->data['ltv'] = $ltv;

        return $this;
    }

    public function setCustomerNumber(?string $customerNumber): self
    {
        $this->data['customer_number'] = $customerNumber;

        return $this;
    }
}
