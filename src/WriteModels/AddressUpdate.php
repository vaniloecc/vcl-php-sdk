<?php

declare(strict_types=1);

namespace VaniloCloud\WriteModels;

use VaniloCloud\Enums\AddressType;

class AddressUpdate extends BaseWriteModel
{
    public function setType(?AddressType $type): self
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

    public function setName(?string $name): self
    {
        $this->data['name'] = $name;

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

    public function setCountry(?string $country): self
    {
        $this->data['country'] = $country;

        return $this;
    }

    public function setProvince(?string $province): self
    {
        $this->data['province'] = $province;

        return $this;
    }

    public function setProvinceId(?string $provinceId): self
    {
        $this->data['province_id'] = $provinceId;

        return $this;
    }

    public function setPostalcode(?string $postalcode): self
    {
        $this->data['postalcode'] = $postalcode;

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

    public function setAccessCode(?string $accessCode): self
    {
        $this->data['access_code'] = $accessCode;

        return $this;
    }
}
