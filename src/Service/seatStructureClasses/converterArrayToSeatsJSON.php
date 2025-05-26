<?php


namespace App\Service\seatStructureClasses;

use App\Enum\CompartmentTypeEnum;
use Throwable;

class converterArrayToSeatsJSON
{
    public function convert(array $seatsArray): string
    {
        $result = ['classes' => []];

        $classesMap = [];

        foreach ($seatsArray as $seat) {
            $classTypeObj = $seat->getCompartmentType() ?? null;

            if ($classTypeObj instanceof CompartmentTypeEnum) {
                $classTypeStr = $classTypeObj->value;
            } elseif (is_string($classTypeObj)) {
                $classTypeStr = $classTypeObj;
            } else {
                continue;
            }

            if (!$classTypeStr) continue;

            // Аналогично для остальных ключей
            $compartmentNumber = $seat->getCompartmentNumber() ?? 1;
            $zoneNumber = $seat->getZoneNumber() ?? 1;
            $sectorNumber = $seat->getSectorNumber() ?? 1;
            $rowNumber = $seat->getRow() ?? 1;
            $seatNumber = $seat->getNumberInRow() ?? 1;
            $seatId = $seat->getId() ?? 1;
            $seatStrDiscription = $seat->getStrDiscription() ?? null;

            try {
                $available = $seat->isAvalible(); // Если брать данные из одних таблиц, то этот метод будет, а в других нет
            } catch (Throwable $e) {
                $available = true;
            }

            if (!isset($classesMap[$compartmentNumber])) {
                $classesMap[$compartmentNumber] = [
                    'classType' => $classTypeStr,
                    'zones' => []
                ];
            }
            $classEntry = &$classesMap[$compartmentNumber];

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
                'seatStatus' => $available,
                'seatID' => $seatId,
                'strDiscription' => $seatStrDiscription,
            ];
        }

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



//
//
//namespace App\Service\seatStructureClasses;
//
//use App\Enum\CompartmentTypeEnum;
//use Throwable;
//
//class converterArrayToSeatsJSON
//{
//    public function convert(array $seatsArray): string
//    {
//        $result = ['classes' => []];
//
//        $classesMap = [];
//
//        foreach ($seatsArray as $seat) {
//            $classTypeObj = $seat->getCompartmentType() ?? null;
//
//            if ($classTypeObj instanceof CompartmentTypeEnum) {
//                $classTypeStr = $classTypeObj->value;
//            } elseif (is_string($classTypeObj)) {
//                $classTypeStr = $classTypeObj;
//            } else {
//                continue;
//            }
//
//            if (!$classTypeStr) continue;
//
//            // Аналогично для остальных ключей
//            $compartmentNumber = $seat->getCompartmentNumber() ?? 1;
//            $zoneNumber = $seat->getZoneNumber() ?? 1;
//            $sectorNumber = $seat->getSectorNumber() ?? 1;
//            $rowNumber = $seat->getRow() ?? 1;
//            $seatNumber = $seat->getNumberInRow() ?? 1;
//            $seatId = $seat->getId() ?? 1;
//
//            try {
//                $available = $seat->isAvalible(); // Если брать данные из одних таблиц, то этот метод будет, а в других нет
//            }
//            catch (Throwable $e){
//                $available = true;
//            }
//
//            if (!isset($classesMap[$classTypeStr])) {
//                $classesMap[$classTypeStr] = [
//                    'classType' => $classTypeStr,
//                    'zones' => []
//                ];
//            }
//            $classEntry = &$classesMap[$classTypeStr];
//
//            if (!isset($classEntry['zones'][$zoneNumber])) {
//                $classEntry['zones'][$zoneNumber] = [
//                    'sectors' => []
//                ];
//            }
//            $zoneEntry = &$classEntry['zones'][$zoneNumber];
//
//            if (!isset($zoneEntry['sectors'][$sectorNumber])) {
//                $zoneEntry['sectors'][$sectorNumber] = [
//                    'rows' => []
//                ];
//            }
//            $sectorEntry = &$zoneEntry['sectors'][$sectorNumber];
//
//            if (!isset($sectorEntry['rows'][$rowNumber])) {
//                $sectorEntry['rows'][$rowNumber] = [
//                    'seats' => []
//                ];
//            }
//            $rowEntry = &$sectorEntry['rows'][$rowNumber];
//
//            $rowEntry['seats'][] = [
//                'seatStatus' => $available,
//                'seatID' => $seatId,
//            ];
//        }
//
//        foreach ($classesMap as &$classData) {
//            $classData['zones'] = array_values($classData['zones']);
//            foreach ($classData['zones'] as &$zone) {
//                $zone['sectors'] = array_values($zone['sectors']);
//
//                foreach ($zone['sectors'] as &$sector) {
//                    $sector['rows'] = array_values($sector['rows']);
//
//                    foreach ($sector['rows'] as &$row) {
//                        $row['seats'] = $row['seats'];
//                    }
//                }
//            }
//        }
//
//        $result['classes'] = array_values($classesMap);
//
//        return json_encode($result, JSON_UNESCAPED_UNICODE);
//    }
//}