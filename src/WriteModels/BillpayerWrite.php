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

    public function setFullName(?string $full_name): self
    {
        $this->data['full_name'] = $full_name;

        return $this;
    }

    public function setCompanyName(?string $company_name): self
    {
        $this->data['company_name'] = $company_name;

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

    public function setIsEuRegistered(bool $is_eu_registered): self
    {
        $this->data['is_eu_registered'] = $is_eu_registered;

        return $this;
    }

    public function setIsOrganization(?bool $is_organization): self
    {
        $this->data['is_organization'] = $is_organization;

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

    public function setProvinceId(?string $province_id): self
    {
        $this->data['province_id'] = $province_id;

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
