<?php

declare(strict_types=1);

namespace VaniloCloud\Models;

use Carbon\CarbonImmutable;
use VaniloCloud\Enums\CustomerType;

class Customer
{
    use HasId;
    use HasTimestamps;
    use HasDynamicAttributeConstructor;

    public readonly ?string $default_shipping_address_id;

    public readonly ?string $default_billing_address_id;

    public readonly ?CustomerType $type;

    public readonly string $name;

    public readonly ?string $firstname;

    public readonly ?string $lastname;

    public readonly ?string $company_name;

    public readonly ?string $tax_nr;

    public readonly ?string $registration_nr;

    public readonly ?string $email;

    public readonly ?string $phone;

    public readonly bool $is_active;

    public readonly ?string $timezone;

    public readonly ?CarbonImmutable $last_purchase_at;

    public readonly ?float $ltv;

    public readonly ?array $addresses;

    public readonly ?string $customer_number;
}
