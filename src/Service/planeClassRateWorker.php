<?php

namespace App\Service;

use App\Entity\Airline;
use App\Entity\BaggagePoliticy;
use App\Entity\PlaneClassRate;
use App\Enum\CompartmentTypeEnum;
use App\Repository\PlaneClassRateRepository;
use Doctrine\ORM\EntityManagerInterface;

class planeClassRateWorker
{
    function __construct(
        private EntityManagerInterface $entityManager,
        private PlaneClassRateRepository $planeClassRateRepository,
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

    function deletePlaneClassForAirline(Airline $airline)
    {
        $baggagePoliticeRates = $this->planeClassRateRepository->findBy(['airlineID' => $airline]);

        foreach ($baggagePoliticeRates as $baggagePoliticeRate)
        {
            $this->entityManager->remove($baggagePoliticeRate);
            $this->entityManager->flush();
        }

    }




}