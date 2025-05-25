<?php

namespace App\Service\seatStructureClasses;

use App\Enum\CompartmentTypeEnum;
use App\Service\getEnumFromString;

class converterSeatsFromJSONtoArray
{
//    private $enumFromString;

    function __construct(
        private getEnumFromString $enumFromString
    )
    {
    }
    public function convert(string $json): array
    {
        $rows = json_decode($json, true);
        $result = [];

        if (!isset($rows['classes'])) {
            return $result; // или выбросить исключение
        }


//        $lastRowNumber = 0;

        $compartmentNumber = 1;
        $lastSeatInRowNumber = 0;

        foreach ($rows['classes'] as $class) {
            $classTypeStr = $class['classType'] ?? '';
            $classType = $this->enumFromString->getCompartmentTypeEnumFromString($classTypeStr);

            $lastRowNumber = 0;

            if (!isset($class['zones'])) {
                continue; // Если зон нет, пропускаем
            }


            foreach ($class['zones'] as $zoneIndex => $zone) {
                $zoneNumber = $zoneIndex + 1; // или взять из данных, если есть
                if (!isset($zone['sectors'])) {
                    continue; // если секторов нет
                }

                $maxRowsInZones = $this->getMaxRowsInZone($zone);

                $lastSeatInRowNumberfromLastClass = $lastSeatInRowNumber;

                foreach ($zone['sectors'] as $sectorIndex => $sector) {
                    $sectorNumber = $sectorIndex + 1; // прибавка, если нужны нумерация

                    if (!isset($sector['rows'])) {
                        continue;
                    }

                    $rowsInZone = count($sector['rows']);

                    foreach ($sector['rows'] as $rowIndex => $row) {
                        $rowNumber = $rowIndex + 1;

                        if (!isset($row['seats'])) {
                            continue;
                        }

                        foreach ($row['seats'] as $seatIndex => $seat) {
                            $seatNumber = $seatIndex + 1;


                            $letterNum = 64 + $lastRowNumber + $this->getCurrectRowNumber($maxRowsInZones, $rowsInZone, $rowNumber);
                            $letter = chr($letterNum);

                            $numberInRow = $seatNumber + $lastSeatInRowNumberfromLastClass;

                            $strDiscription = $letter . "-" . $numberInRow;

                            $result[] = [
                                'compartmentNumber' => $compartmentNumber,
                                'compartmentType' => $classType,
                                'zoneNumber' => $zoneNumber,
                                'sectorNumber' => $sectorNumber,
                                'row' => $rowNumber,
                                'NumberInRow' => $seatNumber,
                                'available' => $seat['available'] ?? null,
                                'strDiscription' => $seat['strDiscription'] ?? $strDiscription,
                            ];
                        }
                    }
                }
                $lastRowNumber += $maxRowsInZones;
            }
            $lastSeatInRowNumber+= $seatNumber;
            $compartmentNumber++;
        }

        return $result;
    }


    private function getMaxRowsInZone(array $zone): int
    {
        $maxRowsInZone = 0;

        foreach ($zone['sectors'] as $sector) {
            $rowsInZone = count($sector['rows']);
            $maxRowsInZone = max($maxRowsInZone, $rowsInZone);
        }

        return $maxRowsInZone;
    }

    private function getCurrectRowNumber(int $maxRowsInZone, int $rowsInZone, int $rowNumber): int
    {
        $isEven = $this->isEven($rowsInZone);
        $middle = $isEven ? $rowsInZone / 2 : (int)($rowsInZone / 2) + 1;

        if ($maxRowsInZone == $rowsInZone || $rowNumber <= $middle) {
            return $rowNumber;
        }

        return $maxRowsInZone - ($rowsInZone - $rowNumber);
    }

    private function isEven($number): bool
    {
        return $number % 2 === 0;
    }

}