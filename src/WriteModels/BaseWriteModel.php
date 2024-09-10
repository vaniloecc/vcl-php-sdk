<?php

namespace VaniloCloud\WriteModels;

class BaseWriteModel
{
    public function toArray(): array
    {
        $array = [];
        foreach (get_object_vars($this) as $property => $value) {
            if ($value instanceof \UnitEnum) {
                // Use the value of the enum
                $array[$property] = $value->value;
            } else {
                $array[$property] = $value;
            }
        }

        return array_filter($array, static fn($value) => $value !== null);
    }
}
