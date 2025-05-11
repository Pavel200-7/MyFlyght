<?php

namespace App\Service;

use App\Enum\CompartmentTypeEnum;

class getEnumFromString
{
    public function getCompartmentTypeEnumFromString(string $typeStr): ?CompartmentTypeEnum
    {
        // Попытка найти enum по строковому значению
        foreach (CompartmentTypeEnum::cases() as $case) {
            if ($case->value === $typeStr) {
                return $case;
            }
        }
        return null; // или можно вернуть дефолтное значение, если подходит
    }

}