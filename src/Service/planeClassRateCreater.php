<?php

namespace App\Service;

use App\Entity\Airline;
use App\Entity\PlaneClassRate;
use App\Enum\CompartmentTypeEnum;
use Doctrine\ORM\EntityManagerInterface;

class planeClassRateCreater
{
    function __construct(
        private EntityManagerInterface $entityManager,
    )
    {}
    function createPlaneClassRateNotes(Airline $airline)
    {
        foreach (CompartmentTypeEnum::cases() as $compartmentType)
        {
            $planeClassRate = new PlaneClassRate();
            $planeClassRate->setAirlineID($airline);
            $planeClassRate->setClassType($compartmentType);
            $planeClassRate->setCostPerKM(0);

            $this->entityManager->persist($planeClassRate);
            $this->entityManager->flush();
        }

    }


}