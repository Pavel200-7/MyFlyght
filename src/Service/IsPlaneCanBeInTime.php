<?php

// Этот класс еще не готов
// Он нужен будет для валидации выбора самолетов
// Сейчас написать его не могу, так как из средств анализа имеется только спинной мозг
// Надеюсь на понимае себя из будущего.

namespace App\Service;

use App\Entity\Airports;
use App\Entity\Flights;
use App\Repository\FlightsRepository;
use Doctrine\ORM\EntityManagerInterface;

class IsPlaneCanBeInTime
{
    private int $extraMinutesPlaneNeed;

    private EntityManagerInterface $entityManager;
    private FlightsRepository $flightsRepository;
    private distanceCalculator $distanceCalculator;
    private flightTimeCalculator $flightTimeCalculator;

    function __construct(
        EntityManagerInterface $entityManager,
        FlightsRepository $flightsRepository,
        distanceCalculator $distanceCalculator,
        flightTimeCalculator $flightTimeCalculator,
    )
    {
        $this->extraMinutesPlaneNeed = 120;


        $this->entityManager = $entityManager;
        $this->flightsRepository = $flightsRepository;
        $this->distanceCalculator = $distanceCalculator;
        $this->flightTimeCalculator = $flightTimeCalculator;

    }


    public function IsPlaneCanBeInTime(Flights $flight): bool
    {
        if ($this->IsThereFlightOverlay($flight)) {
            return false;
        } elseif (!$this->IsPlaneInTimeAfterLastFlight($flight)) {
            return false;
        } elseif (!$this->IsPlaneInTimeBeforeNextFlight($flight)) {
            return false;
        } else {
            return true;
        }
    }

    private function IsThereFlightOverlay(Flights $flight): bool
    {
        $aircraftId = $flight->getAircraftId();
        $sheduledDeparture = $flight->getSheduledDeparture();
        $sheduledArrival = $flight->getSheduledArrival();




        $foundFlights = $this->flightsRepository->createQueryBuilder('f')
            ->where('f.aircraftId = :aircraftId')
            ->andWhere(
                '(f.sheduledArrival BETWEEN :dep AND :arr OR
                         f.sheduledDeparture BETWEEN :dep AND :arr OR
                         f.sheduledDeparture > :dep AND f.sheduledArrival < :arr OR
                         f.sheduledDeparture < :dep AND f.sheduledArrival > :arr)'

            )
            ->setParameter('aircraftId', $aircraftId)
            ->setParameter('dep', $sheduledDeparture)
            ->setParameter('arr', $sheduledArrival)
            ->getQuery()
            ->getResult();

        return empty($foundFlights) ? false : true;
    }


    private function IsPlaneInTimeAfterLastFlight(Flights $flight): bool
    {
        $lastFlight = $this->getLastFlight($flight);

        if (is_null($lastFlight)) {
            return true;
        }

        $departureAirport = $lastFlight->getArrivalAirport();
        $arrivalAirport = $flight->getDepartureAirport();

        $timePlaneNeed = $this->getTimePlaneNeed($departureAirport, $arrivalAirport, $flight);
        $timePlaneHave = $this->getTimePlaneHave($lastFlight->getSheduledArrival(), $flight->getSheduledDeparture());

        return $timePlaneNeed <= $timePlaneHave ? true : false;

    }

    private function IsPlaneInTimeBeforeNextFlight(Flights $flight): bool
    {
        $nextFlight = $this->getNextFlight($flight);

        if (is_null($nextFlight)) {
            return true;
        }

        $departureAirport = $flight->getArrivalAirport();
        $arrivalAirport = $nextFlight->getDepartureAirport();

        $timePlaneNeed = $this->getTimePlaneNeed($departureAirport, $arrivalAirport, $flight);
        $timePlaneHave = $this->getTimePlaneHave($flight->getSheduledArrival(), $nextFlight->getSheduledDeparture());

        return $timePlaneNeed <= $timePlaneHave ? true : false;
    }

    private function getLastFlight(Flights $flight): ?Flights
    {
        $aircraftId = $flight->getAircraftId();
        $sheduledDeparture = $flight->getSheduledDeparture();

        return $this->flightsRepository->createQueryBuilder('f')
            ->where('f.aircraftId = :aircraftId')
            ->andWhere('f.sheduledArrival < :sheduledDeparture')
            ->setParameter('aircraftId', $aircraftId)
            ->setParameter('sheduledDeparture', $sheduledDeparture)
            ->orderBy('f.sheduledArrival', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    private function getNextFlight(Flights $flight): ?Flights
    {
        $aircraftId = $flight->getAircraftId();
        $sheduledArrival = $flight->getSheduledArrival();

        return $this->flightsRepository->createQueryBuilder('f')
            ->where('f.aircraftId = :aircraftId')
            ->andWhere('f.sheduledDeparture > :sheduledArrival')
            ->setParameter('aircraftId', $aircraftId)
            ->setParameter('sheduledArrival', $sheduledArrival)
            ->orderBy('f.sheduledArrival', 'ASC')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    private function getTimePlaneNeed(Airports $departureAirport, Airports $arrivalAirport, Flights $flight): int
    {
        $aircraftId = $flight->getAircraftId();
        $distance = $this->distanceCalculator->calculateDistaceBetweenAirports($departureAirport, $arrivalAirport);
        $timePlaneNeed = $this->flightTimeCalculator->calculateFlightTimeForAircraft($aircraftId, $distance);
        $timePlaneNeed = $timePlaneNeed + $this->extraMinutesPlaneNeed;

        return $timePlaneNeed;
    }

    private function getTimePlaneHave( \DateTimeInterface $time1, \DateTimeInterface $time2,): int
    {
        $interval = $time1->diff($time2);
        $minutes = ($interval->days * 24 * 60) + ($interval->h * 60) + $interval->i;
        $minutes = abs($minutes);

        return $minutes;
    }

}