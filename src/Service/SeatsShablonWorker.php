<?php

namespace App\Service;

use App\Entity\Airline;
use App\Entity\PlaneClassRate;
use App\Entity\SeatShablon;
use App\Enum\CompartmentTypeEnum;
use App\Repository\PlaneClassRateRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\SeatsDiscriptionShablon;

class SeatsShablonWorker
{
    function __construct(
        private EntityManagerInterface $entityManager,
    )
    {}
    function createSeatsShablon(array $seatArray, SeatsDiscriptionShablon $seatsDiscriptionShablon)
    {
        foreach ($seatArray as $seatData)
        {
            $seat = new SeatShablon();
            $seat->setSeatShablon($seatsDiscriptionShablon);
            $seat->setCompartmentType($seatData['compartmentType']);
            $seat->setCompartmentNumber($seatData['compartmentNumber']);
            $seat->setZoneNumber($seatData['zoneNumber']);
            $seat->setSectorNumber($seatData['sectorNumber']);
            $seat->setRow($seatData['row']);
            $seat->setNumberInRow($seatData['NumberInRow']);
            $seat->setStrDiscription($seatData['strDiscription']);

            $this->entityManager->persist($seat);
            $this->entityManager->flush();
        }

    }

    function deleteSeatsShablon(array $seats)
    {
        foreach ($seats as $seat)
        {
            $this->entityManager->remove($seat);
            $this->entityManager->flush();
        }

    }

}