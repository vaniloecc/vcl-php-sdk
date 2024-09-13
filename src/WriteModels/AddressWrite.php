<?php

declare(strict_types=1);

namespace VaniloCloud\WriteModels;

use VaniloCloud\Enums\AddressType;

class AddressWrite extends BaseWriteModel
{
    public function setId(?string $id): self
    {
        $this->data['id'] = $id;

        return $this;
    }

    public function setType(?AddressType $addressType): self
    {
        $this->data['type'] = $addressType;

        return $this;
    }

    public function setName(?string $name): self
    {
        $this->data['name'] = $name;

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

    public function setCountry(?string $country): self
    {
        $this->data['country'] = $country;

        return $this;
    }

    // TODO
    public function setProvince(?ProvinceWrite $provinceWrite): self
    {
        $this->data['province'] = $provinceWrite?->toArray();

        return $this;
    }

    public function setCity(?string $city): self
    {
        $this->data['city'] = $city;

        return $this;
    }

    public function setAddress(?string $address): self
    {
        $this->data['address'] = $address;

        return $this;
    }

    public function setAddress2(?string $address2): self
    {
        $this->data['address2'] = $address2;

        return $this;
    }

    public function setPostalCode(?string $postalcode): self
    {
        $this->data['postalcode'] = $postalcode;

        return $this;
    }

    public function setTaxNr(?string $tax_nr): self
    {
        $this->data['tax_nr'] = $tax_nr;

        return $this;
    }

    public function setRegistrationNr(?string $registration_nr): self
    {
        $this->data['registration_nr'] = $registration_nr;

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

    public function setAccessCode(?string $access_code): self
    {
        $this->data['access_code'] = $access_code;

        return $this;
    }

    // todo carbon
    public function setCreatedAt(?string $created_at): self
    {
        $this->data['created_at'] = $created_at;

        return $this;
    }

    // todo carbon
    public function setUpdatedAt(?string $updated_at): self
    {
        $this->data['updated_at'] = $updated_at;

        return $this;
    }
}
