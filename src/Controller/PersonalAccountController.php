<?php

namespace App\Controller;

use App\Repository\TicketsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PersonalAccountController extends AbstractController
{
    #[Route('/personal/account', name: 'app_personal_account')]
    public function index(TicketsRepository $ticketsRepository): Response
    {

        $user = $this->getUser();
        if (!$user) {
            // Для незарегистрировавшихся
            return $this->render('personal_account/index_empty.html.twig');
        }


        $tickets = $ticketsRepository->findBy(['clientId' => $user]);

        $ticketIds = array_map(function($ticket) {
            return $ticket->getId();
        }, $tickets);


        $flightsInfo = array();
        foreach ($tickets as $ticket) {
            $flight = $ticket->getFlightSeatsId()->getFlightId();
            $flightID = $flight->getId();

            if (array_key_exists($flightID, $flightsInfo)) {
                continue;
            }

            $query = $ticketsRepository->createQueryBuilder('t')
                ->where('t.clientId = :client')
                ->andWhere('t.id IN (:ticketIds)')
                ->setParameter('client', $user)
                ->setParameter('ticketIds', $ticketIds, \Doctrine\DBAL\Connection::PARAM_INT_ARRAY);

            $tickets = $query->getQuery()->getResult();

            $flightInfo["flight"] = $flight;
            $flightInfo["tickets"] = $tickets;
            $flightsInfo[$flightID] = $flightInfo;
        }

        return $this->render('personal_account/index.html.twig', [
            'controller_name' => 'PersonalAccountController',
            'user' => $user,
            'flightsInfo' => $flightsInfo,
        ]);
    }
}
