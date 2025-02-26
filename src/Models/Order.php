<?php

declare(strict_types=1);

namespace VaniloCloud\Models;

use Carbon\CarbonImmutable;
use VaniloCloud\Attributes\ArrayOf;
use VaniloCloud\Enums\FulfillmentStatus;
use VaniloCloud\Enums\OrderStatus;

class Order
{
    use HasId;
    use HasTimestamps;
    use HasDynamicAttributeConstructor;

    public readonly string $number;

    public readonly OrderStatus $status;

    public readonly FulfillmentStatus $fulfillment_status;

    public readonly ?string $user_id;

    public readonly ?string $customer_id;

    public readonly ?array $channel;

    public readonly ?string $payable_remote_id;

    public readonly ?string $reseller;

    public readonly ?string $affiliate;

    public readonly ?string $notes;

    public readonly CarbonImmutable $ordered_at;

    public readonly ?Billpayer $billing_address;

    public readonly ?Address $shipping_address;

    public readonly ?ShippingMethod $shipping_method;

    public readonly ?PaymentMethod $payment_method;

    public readonly ?array $payments;

    public readonly ?array $shipments;

    public readonly ?array $adjustments;

    #[ArrayOf(OrderItem::class)]
    public readonly array $items;

    public readonly array $invoices;

    public readonly ?string $currency;

    public readonly ?string $language;
}
