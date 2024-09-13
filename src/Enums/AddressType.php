<?php

declare(strict_types=1);

namespace VaniloCloud\Enums;

enum AddressType: string
{
    case BILLING = 'billing';
    case BUSINESS = 'business';
    case CONTRACT = 'contract';
    case MAILING = 'mailing';
    case PICKUP = 'pickup';
    case RESIDENTIAL = 'residential';
    case SHIPPING = 'shipping';

    // todo handle default null
    /*public static function default(): self
    {
        return self::PRODUCT;
    }*/
}
