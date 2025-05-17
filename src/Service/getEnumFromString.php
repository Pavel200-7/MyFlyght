<?php

namespace App\Service;

use App\Enum\CompartmentTypeEnum;

class getEnumFromString
{
    public function getCompartmentTypeEnumFromString(string $typeStr): ?CompartmentTypeEnum
    {
        foreach (CompartmentTypeEnum::cases() as $case) {
            if ($case->value === $typeStr) {
                return $case;
            }
        }
        return null;
    }

}