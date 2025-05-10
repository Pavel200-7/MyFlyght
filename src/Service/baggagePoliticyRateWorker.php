<?php

namespace App\Service;

use App\Entity\Airline;
use App\Entity\BaggagePoliticy;
use App\Entity\BaggagePoliticyRate;
use App\Repository\AirlineRepository;
use App\Repository\BaggagePoliticyRateRepository;
use App\Repository\BaggagePoliticyRepository;
use Doctrine\ORM\EntityManagerInterface;
use function Symfony\Component\Translation\t;

class baggagePoliticyRateWorker
{
    function __construct(
        private EntityManagerInterface $entityManager,
        private BaggagePoliticyRepository $baggagePoliticyRepository,
        private BaggagePoliticyRateRepository $baggagePoliticyRateRepository,
        private AirlineRepository $airlineRepository,
    )
    {}

    function createBaggagePoliticesRateNotes(Airline $airline)
    {
        $baggagePolitices = $this->baggagePoliticyRepository->findAll();
        foreach ($baggagePolitices as $baggagePoliticy)
        {
            $baggagePoliticyRate = new BaggagePoliticyRate();
            $baggagePoliticyRate->setAirlane($airline);
            $baggagePoliticyRate->setBaggagePoliticyID($baggagePoliticy);
            $baggagePoliticyRate->setCostPerKM(0);

            $this->entityManager->persist($baggagePoliticyRate);
            $this->entityManager->flush();
        }

    }

    function createNewBaggagePoliticesRateNote(BaggagePoliticy $baggagePoliticy)
    {
        $airlines = $this->airlineRepository->findAll();
        foreach ($airlines as $airline)
        {
            $baggagePoliticyRate = new BaggagePoliticyRate();
            $baggagePoliticyRate->setAirlane($airline);
            $baggagePoliticyRate->setBaggagePoliticyID($baggagePoliticy);
            $baggagePoliticyRate->setCostPerKM(0);

            $this->entityManager->persist($baggagePoliticyRate);
            $this->entityManager->flush();
        }

    }

    function deleteBaggagePolitice(BaggagePoliticy $baggagePoliticy)
    {
        $baggagePoliticeRates = $this->baggagePoliticyRateRepository->findBy(['baggagePoliticyID' => $baggagePoliticy]);

        foreach ($baggagePoliticeRates as $baggagePoliticeRate)
        {
            $this->entityManager->remove($baggagePoliticeRate);
            $this->entityManager->flush();
        }


    }

}