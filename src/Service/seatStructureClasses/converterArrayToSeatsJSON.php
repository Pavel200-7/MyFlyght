<?php

namespace App\Service\seatStructureClasses;

use App\Enum\CompartmentTypeEnum;

class converterArrayToSeatsJSON
{
    public function convert(array $seatsArray): string
    {
        $result = ['classes' => []];

        $classesMap = [];

        foreach ($seatsArray as $seat) {
            // Вместо $seat['compartmentType']
            $classTypeObj = $seat->getCompartmentType();

            // Проверка типа
            if ($classTypeObj instanceof CompartmentTypeEnum) {
                $classTypeStr = $classTypeObj->value; // получаем строковое значение
            } elseif (is_string($classTypeObj)) {
                $classTypeStr = $classTypeObj; // если строка
            } else {
                // Невалидное значение, пропускаем
                continue;
            }

            if (!$classTypeStr) continue;

            // Аналогично для остальных ключей
            $compartmentNumber = $seat->getCompartmentNumber() ?? 1; // предполагается что есть геттер
            $zoneNumber = $seat->getZoneNumber() ?? 1;
            $sectorNumber = $seat->getSectorNumber() ?? 1;
            $rowNumber = $seat->getRow() ?? 1;
            $seatNumber = $seat->getNumberInRow() ?? 1;
            $available = true; // у вас нет метода getAvailable(), добавьте при необходимости

            // остальной код без изменений
            if (!isset($classesMap[$classTypeStr])) {
                $classesMap[$classTypeStr] = [
                    'classType' => $classTypeStr,
                    'zones' => []
                ];
            }
            $classEntry = &$classesMap[$classTypeStr];

            if (!isset($classEntry['zones'][$zoneNumber])) {
                $classEntry['zones'][$zoneNumber] = [
                    'sectors' => []
                ];
            }
            $zoneEntry = &$classEntry['zones'][$zoneNumber];

            if (!isset($zoneEntry['sectors'][$sectorNumber])) {
                $zoneEntry['sectors'][$sectorNumber] = [
                    'rows' => []
                ];
            }
            $sectorEntry = &$zoneEntry['sectors'][$sectorNumber];

            if (!isset($sectorEntry['rows'][$rowNumber])) {
                $sectorEntry['rows'][$rowNumber] = [
                    'seats' => []
                ];
            }
            $rowEntry = &$sectorEntry['rows'][$rowNumber];

            $rowEntry['seats'][] = [
                'seatStatus' => $available
            ];
        }

        // остальной код
        foreach ($classesMap as &$classData) {
            $classData['zones'] = array_values($classData['zones']);
            foreach ($classData['zones'] as &$zone) {
                $zone['sectors'] = array_values($zone['sectors']);

                foreach ($zone['sectors'] as &$sector) {
                    $sector['rows'] = array_values($sector['rows']);

                    foreach ($sector['rows'] as &$row) {
                        $row['seats'] = $row['seats'];
                    }
                }
            }
        }

        $result['classes'] = array_values($classesMap);

        return json_encode($result, JSON_UNESCAPED_UNICODE);
    }
}