<?php

declare(strict_types=1);

namespace VaniloCloud\Enums;

enum OrderStatus: string
{
    case PENDING = 'pending';
    case PROCESSING = 'processing';
    case COMPLETED = 'completed';
    case CANCELLED = 'cancelled';

    public static function default(): self
    {
        return self::PENDING;
    }
}
