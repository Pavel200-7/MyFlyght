<?php

namespace App\Service;

use App\Repository\BaggagePoliticyRateRepository;
use App\Repository\PlaneClassRateRepository;

class getFlightPricesInfo
{
    function __construct(
        private PlaneClassRateRepository $planeClassRateRepository,
        private BaggagePoliticyRateRepository $baggagePoliticyRateRepository,
        private distanceCalculator $distanceCalculator,
    )
    {}

    public function getFlightPricesInfo($FlightsData, $classType)
    {
        foreach ($FlightsData as $FlightData)
        {
            $airline = $FlightData->getAirliniID();
            $baggageType = $FlightData->getBaggagePoliticyID();

            $priseOfClassPerKM = $this->getPriseOfClassPerKM($airline, $classType);
            $priseOfBaggagePerKM = $this->getPriseOfBaggagePerKM($airline, $baggageType);

            $distanse = $this->getFlightDistance($FlightData);

            $ticketPrice = (int) $distanse * $priseOfClassPerKM;
            $baggagePrice = (int) $distanse * $priseOfBaggagePerKM;

            $FlightData->ticketPrice = $ticketPrice;
            $FlightData->baggagePrice = $baggagePrice;
        }
        return $FlightsData;
    }

    private function getFlightDistance($FlightData):float
    {
        $firstPlace = $FlightData->getDepartureAirport();
        $secondPlace = $FlightData->getArrivalAirport();

        $latitude1 = $firstPlace->getLatitude();
        $longitude1 = $firstPlace->getLongtitude();
        $latitude2 = $secondPlace->getLatitude();
        $longitude2 = $secondPlace->getLongtitude();

        $distanse = $this->distanceCalculator->calculateDistace($latitude1,  $longitude1,  $latitude2,  $longitude2);

        return $distanse;

    }

    private function getPriseOfClassPerKM($airline, $classType)
    {
        $result = $this->planeClassRateRepository->findBy(['airlineID' => $airline, 'classType' => $classType]);
        return $result[0]->getCostPerKM();
    }

    private function getPriseOfBaggagePerKM($airline, $baggageType)
    {
        $result = $this->baggagePoliticyRateRepository->findBy(['airlineID' => $airline, 'baggagePoliticyID' => $baggageType]);
        return $result[0]->getCostPerKM();
    }

}