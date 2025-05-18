<?php

namespace App\Controller;

use App\Entity\FlightsSeats;
use App\Entity\SeatShablon;
use App\Entity\Tickets;
use App\Form\MainPageType;
use App\Form\TicketsOrderType;
use App\Form\TicketsType;
use App\Repository\FlightsRepository;
use App\Repository\TicketsRepository;
use App\Service\flightFinder;
use App\Service\getFlightPricesInfo;
use App\Service\orderPerformer;
use App\Service\seatStructureClasses\converterArrayToSeatsJSON;
use App\Service\seatStructureClasses\converterSeatsFromJSONtoArray;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/tickets')]
final class TicketsController extends AbstractController
{
    #[Route(name: 'app_tickets_index', methods: ['GET', 'POST'])]
    public function index(
        TicketsRepository $ticketsRepository, 
        Request $request, 
        FlightsRepository $flightsRepository, 
        getFlightPricesInfo $flightPricesInfo,
    ): Response
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
        }

        return $this->render('tickets/index.html.twig', [
            'tickets' => $ticketsRepository->findAll(),
            'form' => $form,
            'needFlightsData' => $needFlightsData,
            'classType' => $classType,
        ]);
    }

    #[Route('/order/{flightId}/{classType}', name: 'app_order_tickets', methods: ['GET', 'POST'])]
    public function orderTickets(
        $flightId, 
        $classType,
        FlightsRepository $flightsRepository,
        getFlightPricesInfo $flightPricesInfo,
        EntityManagerInterface $entityManager,
        converterArrayToSeatsJSON $arrayToSeatsJSON,
        converterSeatsFromJSONtoArray $converterSeatsFromJSONtoArray,

    ): Response
    {
        $needFlightsData = $flightsRepository->findNeedFlightsData($flightId);
        $needFlightsData = $flightPricesInfo->getFlightPricesInfo($needFlightsData , $classType);

        $seats = $entityManager->getRepository(FlightsSeats::class)->findBy(['flightId' => $flightId, 'compartmentType' => $classType]);
        $seatStructure = $arrayToSeatsJSON->convert($seats);

        return $this->render('tickets/tickets_order.html.twig', [
            'needFlightsData' => $needFlightsData,
            'seatStructure' =>  $seatStructure,
        ]);

    }


    #[Route('/buy', name: 'app_buy_tickets', methods: ['GET', 'POST'])]
    public function BuyTickets(
        Request $request,
        orderPerformer $orderPerformer,

    )
    {
        $jsonString = $request->request->get('tickets_order_JSON');
        if (!$jsonString) {
            throw new \Exception("Нет данных заказа");
        }
        $ticketsData = json_decode($jsonString, true);

        $user = $this->getUser();
        if (!$user) {
            $this->addFlash('notice', 'Для совершения заказа требуется регистрация!');
        } elseif (empty($ticketsData)) {
            $this->addFlash('notice', 'Заказ пуст!');
        } else {
            try {
                $orderPerformer->processTickets($ticketsData, $user, new \DateTime());
                $this->addFlash('notice', 'Билеты успешно приобретены!');
            } catch (\Exception $e) {
                $this->addFlash('notice', $e->getMessage());
            }
        }

        $referer = $request->headers->get('referer');
        return $this->redirect($referer);

    }
}
