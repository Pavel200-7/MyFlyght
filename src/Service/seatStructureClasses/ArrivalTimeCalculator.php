<?php

namespace App\Service\seatStructureClasses;

use App\Entity\Airports;
use App\Entity\Flights;
use App\Service\distanceCalculator;
use App\Service\flightTimeCalculator;

class ArrivalTimeCalculator
{

    public function __construct(
        private distanceCalculator $distanceCalculator,
        private flightTimeCalculator $flightTimeCalculator,
    )
    {}

    public function calculateArrivalTime(Flights $flight){

        $airport1 = $flight->getDepartureAirport();
        $airport2 = $flight->getArrivalAirport();
        $distance = $this->distanceCalculator->calculateDistaceBetweenAirports($airport1, $airport2);

        $aircraft = $flight->getAircraftId();
        $flighttimeInMinute = $this->flightTimeCalculator->calculateFlightTimeForAircraft($aircraft, $distance);

        $shedualArrivalTime = clone $flight->getSheduledDeparture();
        $shedualArrivalTime->modify("+$flighttimeInMinute minutes");

        return $shedualArrivalTime;
    }

}