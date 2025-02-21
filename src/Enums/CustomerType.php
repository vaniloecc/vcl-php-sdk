<?php

declare(strict_types=1);

namespace VaniloCloud\Enums;

enum CustomerType: string
{
    case ORGANIZATION = 'organization';
    case INDIVIDUAL = 'individual';
}
