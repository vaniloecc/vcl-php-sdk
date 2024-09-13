<?php

declare(strict_types=1);

namespace VaniloCloud\Enums;

enum FulfillmentStatus: string
{
    case UNFULFILLED = 'unfulfilled';
    case PROCESSING = 'scheduled';
    case ON_HOLD = 'on_hold';
    case AWAITING_SHIPMENT = 'awaiting_shipment';
    case PARTIALLY_FULFILLED = 'partially_fulfilled';
    case READY_FOR_PICKUP = 'ready_for_pickup';
    case FULFILLED = 'fulfilled';

    public static function default(): self
    {
        return self::UNFULFILLED;
    }
}
