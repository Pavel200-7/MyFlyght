<?php

namespace App\Repository;

use App\Entity\Airline;
use App\Entity\BaggagePoliticy;
use App\Entity\BaggagePoliticyRate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BaggagePoliticyRate>
 */
class BaggagePoliticyRateRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry $registry,
        private EntityManagerInterface $entityManager,
        private BaggagePoliticyRepository $baggagePoliticyRepository,
//        private BaggagePoliticyRepository $baggagePoliticyRepository,
        private AirlineRepository $airlineRepository,
    )
    {
        parent::__construct($registry, BaggagePoliticyRate::class);
    }


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
        $baggagePoliticeRates = $this->findBy(['baggagePoliticyID' => $baggagePoliticy]);

        foreach ($baggagePoliticeRates as $baggagePoliticeRate)
        {
            $this->entityManager->remove($baggagePoliticeRate);
            $this->entityManager->flush();
        }

    }



    //    /**
    //     * @return BaggagePoliticyRate[] Returns an array of BaggagePoliticyRate objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('b.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?BaggagePoliticyRate
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
