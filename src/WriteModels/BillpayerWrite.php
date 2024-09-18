<?php

declare(strict_types=1);

namespace VaniloCloud\WriteModels;

class BillpayerWrite extends BaseWriteModel
{
    public function setEmail(string $email): self
    {
        $this->data['email'] = $email;

        return $this;
    }

    public function setPhone(?string $phone): self
    {
        $this->data['phone'] = $phone;

        return $this;
    }

    public function setFirstname(string $firstname): self
    {
        $this->data['firstname'] = $firstname;

        return $this;
    }

    public function setLastname(string $lastname): self
    {
        $this->data['lastname'] = $lastname;

        return $this;
    }

    public function setFullName(?string $fullName): self
    {
        $this->data['full_name'] = $fullName;

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

    public function setIsEuRegistered(bool $isEuRegistered): self
    {
        $this->data['is_eu_registered'] = $isEuRegistered;

        return $this;
    }

    public function setIsOrganization(?bool $isOrganization): self
    {
        $this->data['is_organization'] = $isOrganization;

        return $this;
    }

    public function setCountry(string $country): self
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

    public function setPostalCode(?string $postalcode): self
    {
        $this->data['postalcode'] = $postalcode;

        return $this;
    }

    public function setCity(string $city): self
    {
        $this->data['city'] = $city;

        return $this;
    }

    public function setAddress(string $address): self
    {
        $this->data['address'] = $address;

        return $this;
    }
}
