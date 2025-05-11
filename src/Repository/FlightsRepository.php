<?php

namespace App\Repository;

use App\Entity\Flights;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Flights>
 */
class FlightsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Flights::class);
    }

    function findNeedFlightsID($form)
    {
        // Подготовка переменных для параметров
        $departureCity = $form->get('departureCity')->getData()->getId();
        $arrivalCity = $form->get('arrivalCity')->getData()->getId();

        $dateOfDeparture = $form->get('sheduledDeparture')->getData();
        $dateOfDeparture = $dateOfDeparture->format('Y-m-d');

        $personCount = $form->get('PersonCount')->getData();
        $servisClass = $form->get('ServisClass')->getData()->value; // Так как это перечисление

        // соединение с БД и подготовка запроса
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT id FROM (
                SELECT
                f.id,
                COUNT(sf.id) as seatCount,
                TO_CHAR(f.sheduled_departure, \'YYYY-MM-DD\') as departure_date
            FROM flights f
            INNER JOIN flights_seats sf ON f.id = sf.flights_id
            WHERE
                sf.compartment_type = :compartmentType
                AND f.departure_airports_id IN
                    (
                        SELECT id FROM airports
                        WHERE city_id = :departureCity
                    )
                AND f.arrival_airports_id IN
                    (
                        SELECT id FROM airports
                        WHERE city_id = :arrivalCity
                    )
                AND f.sheduled_departure::date = :dateOfDeparture
            GROUP BY
                sf.compartment_type,
                f.id
            HAVING COUNT(sf.id) >= :needSeatCount   
            )
        ';

        // Подготоввка параметров
        $result = $conn->executeQuery($sql, [
            'compartmentType'=>$servisClass,
            'departureCity'=> $departureCity,
            'arrivalCity'=> $arrivalCity,
            'dateOfDeparture' => $dateOfDeparture,
            'needSeatCount' => $personCount
        ]);

        $results = $result->fetchAllAssociative();

        return $results;
    }

    //    /**
    //     * @return Flights[] Returns an array of Flights objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('f.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Flights
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
