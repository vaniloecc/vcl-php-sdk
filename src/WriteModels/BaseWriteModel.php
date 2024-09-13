<?php

declare(strict_types=1);

namespace VaniloCloud\WriteModels;

abstract class BaseWriteModel
{
    protected array $data = [];

    public function toArray(): array
    {
        $array = [];
        foreach ($this->data as $property => $value) {
            if ($value instanceof \UnitEnum) {
                $array[$property] = $value->value;
            } else {
                $array[$property] = $value;
            }
        }

        return $array;
    }
}
