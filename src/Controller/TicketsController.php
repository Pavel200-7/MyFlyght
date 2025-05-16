<?php

namespace App\Controller;

use App\Form\MainPageType;
use App\Repository\FlightsRepository;
use App\Repository\TicketsRepository;
use App\Service\flightFinder;
use App\Service\getFlightPricesInfo;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/tickets')]
final class TicketsController extends AbstractController
{
    #[Route(name: 'app_tickets_index', methods: ['GET', 'POST'])]
    public function index(TicketsRepository $ticketsRepository, Request $request, FlightsRepository $flightsRepository, getFlightPricesInfo $flightPricesInfo): Response
    {
        $form = $this->createForm(MainPageType::class);
        $form->handleRequest($request);
        $needFlightsData = [];
        $classType = "";

        if ($form->isSubmitted() && $form->isValid()) {
            $needFlightsID = $flightsRepository->findNeedFlightsID($form);

            $needFlightsData = $flightsRepository->findNeedFlightsData($needFlightsID);

            $classType = $form->get('ServisClass')->getData()->value; // Так как это перечисление
            $needFlightsData = $flightPricesInfo->getFlightPricesInfo($needFlightsData , $classType);
//            dd($needFlightsData);
        }

        return $this->render('tickets/index.html.twig', [
            'tickets' => $ticketsRepository->findAll(),
            'form' => $form,
            'needFlightsData' => $needFlightsData,
            'classType' => $classType,
        ]);
    }
}
