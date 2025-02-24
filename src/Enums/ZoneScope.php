<?php

declare(strict_types=1);

namespace VaniloCloud\Enums;

enum ZoneScope: string
{
    case SHIPPING = 'shipping';
    case BILLING = 'billing';
    case TAXATION = 'taxation';
    case PRICING = 'pricing';
    case CONTENT = 'content';
}
