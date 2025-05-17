<?php

namespace App\Controller;

use App\Repository\FlightsRepository;
use App\Repository\TicketsRepository;
use App\Service\getFlightPricesInfo;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/tickets')]
final class OrderTicketsController extends AbstractController
{
    #[Route('/order/{ticketId}/{classType}', name: 'app_tickets_order_index', methods: ['GET'])]
    public function index(string $ticketId, string $classType, FlightsRepository $flightsRepository, getFlightPricesInfo $flightPricesInfo): Response
    {
        $needFlightsData = $flightsRepository->findNeedFlightsData($ticketId);
        $needFlightsData = $flightPricesInfo->getFlightPricesInfo($needFlightsData , $classType);


        return $this->render('order_tickets/index.html.twig', [
            '$needFlightsData' => $needFlightsData,
        ]);
    }

}
