<?php

declare(strict_types=1);

namespace VaniloCloud\Enums;

enum ProductState: string
{
    case DRAFT = 'draft';
    case INACTIVE = 'inactive';
    case ACTIVE = 'active';
    case UNAVAILABLE = 'unavailable';
    case RETIRED = 'retired';

    public static function default(): self
    {
        return self::DRAFT;
    }
}
