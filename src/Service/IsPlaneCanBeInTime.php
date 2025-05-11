<?php

// Этот класс еще не готов
// Он нужен будет для валидации выбора самолетов
// Сейчас написать его не могу, так как из средств анализа имеется только спинной мозг
// Надеюсь на понимае себя из будущего.

namespace App\Service;

use App\Entity\Flights;
use Doctrine\ORM\EntityManagerInterface;

class IsPlaneCanBeInTime
{
    private EntityManagerInterface $entityManager;

    function __construct(
        EntityManagerInterface $entityManager,
    )
    {
        $this->entityManager = $entityManager;

    }


    private function IsPlaneCanBeInTime($thisFlight): bool
    {
        $flightsRepository = $this->entityManager->getRepository(Flights::class);;
        $lastFlightOfPlane = $flightsRepository->createQueryBuilder('f')
            ->where('f.aircraft = :aircraftId')
            ->AndWhere('f.sheduledArrival <= :sheduledDeparture')
            ->setParameter('aircraftId', $this->aircraftId)
            ->setParameter('sheduledDeparture', $this->sheduledDeparture)
            ->orderBy('f.sheduledArrival', 'DESC') // сортируем по убыванию
            ->setMaxResults(1) // берем только одну — самую позднюю
            ->getQuery()
            ->getOneOrNullResult();

        if ($lastFlightOfPlane === null) {
            return true;
        } else {
            $lastArrivalAirport = $lastFlightOfPlane->getArrivalAirport();

            $latitude1 = $lastArrivalAirport->getLatitude();
            $longitude1 = $lastArrivalAirport->getLongtitude();

            $latitude2 = $thisFlight->getDepartureAirport()->getLatitude();
            $longitude2 = $thisFlight->getDepartureAirport()->getLongtitude();

            $distanceCalculator = new DistanceCalculator();
            $distance = $distanceCalculator->calculateDistace($latitude1, $longitude1, $latitude2, $longitude2);

            $planeSpeed = $thisFlight->getAircraftId()->getAircraftModelId()->getAverageSpeed();

            $timeThePlaneNeed = $distance / $planeSpeed;
            $timeThePlaneHave = $thisFlight->getSheduledDeparture() - $lastFlightOfPlane->getSheduledArrival();

            if ($timeThePlaneHave >= $timeThePlaneNeed)
            {
                return true;
            }
        }

        return false;

    }

}