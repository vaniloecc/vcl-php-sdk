<?php

declare(strict_types=1);

namespace VaniloCloud\Models;

class Billpayer
{
    use HasId;
    use HasTimestamps;
    use HasDynamicAttributeConstructor;

    public readonly ?string $email;

    public readonly ?string $phone;

    public readonly ?string $firstname;

    public readonly ?string $lastname;

    public readonly ?string $full_name;

    public readonly ?string $company_name;

    public readonly ?string $tax_nr;

    public readonly ?string $registration_nr;

    public readonly bool $is_eu_registered;

    public readonly bool $is_organization;

    public readonly ?string $country;

    public readonly ?Province $province;

    public readonly ?string $postalcode;

    public readonly ?string $city;

    public readonly ?string $address;
}
