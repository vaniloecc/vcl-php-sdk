<?php

declare(strict_types=1);

namespace VaniloCloud\Models;

class PaymentMethod
{
    use HasId;
    use HasDynamicAttributeConstructor;

    public readonly ?string $name;

    public readonly ?string $gateway;

    public readonly ?array $configuration;

    public readonly bool $is_enabled;

    public readonly ?int $transaction_count;
}
