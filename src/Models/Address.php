<?php

declare(strict_types=1);

namespace VaniloCloud\Models;

use VaniloCloud\Enums\AddressType;

class Address
{
    use HasId;
    use HasTimestamps;
    use HasDynamicAttributeConstructor;

    public readonly ?AddressType $type;

    public readonly ?string $name;

    public readonly ?string $firstname;

    public readonly ?string $lastname;

    public readonly ?string $company_name;

    public readonly ?string $country;

    public readonly ?Province $province;

    public readonly ?string $city;

    public readonly ?string $address;

    public readonly ?string $address2;

    public readonly ?string $postalcode;

    public readonly ?string $tax_nr;

    public readonly ?string $registration_nr;

    public readonly ?string $email;

    public readonly ?string $phone;

    public readonly ?string $access_code;
}
