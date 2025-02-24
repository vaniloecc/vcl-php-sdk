<?php

declare(strict_types=1);

namespace VaniloCloud\Models;

use VaniloCloud\Enums\ZoneScope;

class Zone
{
    use HasId;
    use HasDynamicAttributeConstructor;

    public readonly ?string $name;

    public readonly ZoneScope $scope;
}
