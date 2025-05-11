<?php

namespace App\Service;

class distanceCalculator
{

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