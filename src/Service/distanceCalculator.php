<?php

namespace App\Service;

use App\Entity\Airports;

class distanceCalculator
{

//    public function __construct(
//        private
//
//    )
//    {}

    public function calculateDistaceBetweenAirports(Airports $airport1, Airports $airport2): float
    {
        $latitude1 = $airport1->getLatitude();
        $longitude1 = $airport1->getLongtitude();
        $latitude2 = $airport2->getLatitude();
        $longitude2 = $airport2->getLongtitude();

        return $this->calculateDistace($latitude1, $longitude1, $latitude2, $longitude2);
    }

    function calculateDistace(float $latitude1, float $longitude1, float $latitude2, float $longitude2): float
    {
        // Радиус Земли в километрах
        $earthRadius = 6371;

        // Переводим координаты в радианы
        $lat1 = deg2rad($latitude1);
        $lon1 = deg2rad($longitude1);
        $lat2 = deg2rad($latitude2);
        $lon2 = deg2rad($longitude2);

        // Вычисляем разницы
        $dLat = $lat2 - $lat1;
        $dLon = $lon2 - $lon1;

        // Формула haversine
        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos($lat1) * cos($lat2) *
            sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        // Расстояние
        $distance = $earthRadius * $c;

        return $distance; // в километрах
    }


}