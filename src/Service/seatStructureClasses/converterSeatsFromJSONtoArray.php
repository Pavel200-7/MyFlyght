<?php

namespace App\Service\seatStructureClasses;

use App\Enum\CompartmentTypeEnum;

class converterSeatsFromJSONtoArray
{
    public function convert(string $json): array
    {
        $rows = json_decode($json, true);
        $result = [];

        if (!isset($rows['classes'])) {
            return $result; // или выбросить исключение
        }

        $compartmentNumber = 1;
        foreach ($rows['classes'] as $class) {
            $classTypeStr = $class['classType'] ?? '';
            $classType = $this->getCompartmentTypeEnumFromString($classTypeStr);

            if (!isset($class['zones'])) {
                continue; // Если зон нет, пропускаем
            }

            foreach ($class['zones'] as $zoneIndex => $zone) {
                // тут можете добавлять инфо о зоне, если нужно
                $zoneNumber = $zoneIndex + 1; // или взять из данных, если есть
                if (!isset($zone['sectors'])) {
                    continue; // если секторов нет
                }

                foreach ($zone['sectors'] as $sectorIndex => $sector) {
                    $sectorNumber = $sectorIndex + 1; // прибавка, если нужны нумерация

                    if (!isset($sector['rows'])) {
                        continue;
                    }

                    foreach ($sector['rows'] as $rowIndex => $row) {
                        $rowNumber = $rowIndex + 1;

                        if (!isset($row['seats'])) {
                            continue;
                        }

                        foreach ($row['seats'] as $seatIndex => $seat) {
                            $seatNumber = $seatIndex + 1;

                            $result[] = [
                                'compartmentType' => $classType,
                                'compartmentNumber' => $compartmentNumber,
                                'zoneNumber' => $zoneNumber,
                                'sectorNumber' => $sectorNumber,
                                'row' => $rowNumber,
                                'seatNumber' => $seatNumber,
                                'available' => $seat['available'] ?? null
                            ];
                        }
                    }
                }
            }
            $compartmentNumber++;
        }

        return $result;
    }


    private function getCompartmentTypeEnumFromString(string $typeStr): ?CompartmentTypeEnum
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