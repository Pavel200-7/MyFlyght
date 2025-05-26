<?php

namespace App\Service;

use App\Entity\Aircraft;

class flightTimeCalculator
{
    public function calculateFlightTimeForAircraft(Aircraft $aircraft, float $distance)
    {
        $averageSpeed = $aircraft->getAircraftModelId()->getAverageSpeed();
        $flightTime = $distance / $averageSpeed;

        $timeInMinutes = round((60 * $flightTime));
        $finalTimeinMinutes = round(($timeInMinutes/10) + 1) * 10;

        return $finalTimeinMinutes;
    }

}