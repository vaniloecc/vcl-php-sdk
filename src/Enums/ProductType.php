<?php

declare(strict_types=1);

namespace VaniloCloud\Enums;

enum ProductType: string
{
    case PRODUCT = 'product';
    case MASTER_PRODUCT_VARIANT = 'master_product_variant';

    public static function default(): self
    {
        return self::PRODUCT;
    }
}
