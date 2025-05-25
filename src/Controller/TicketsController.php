<?php

namespace App\Controller;

use App\Entity\FlightsSeats;
use App\Form\MainPageType;
use App\Repository\CitiesRepository;
use App\Repository\FlightsRepository;
use App\Repository\TicketsRepository;
use App\Service\flightFinder;
use App\Service\getEnumFromString;
use App\Service\getFlightPricesInfo;
use App\Service\orderPerformer;
use App\Service\seatStructureClasses\converterArrayToSeatsJSON;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/tickets')]
final class TicketsController extends AbstractController
{
    private CitiesRepository $citiesRepository;
    private getEnumFromString $getEnumFromString;

    public function __construct(
        CitiesRepository $citiesRepository,
        getEnumFromString $getEnumFromString,
    )
    {
        $this->citiesRepository = $citiesRepository;
        $this->getEnumFromString = $getEnumFromString;
    }


    #[Route(name: 'app_tickets_index', methods: ['GET', 'POST'])]
    public function index(
        TicketsRepository $ticketsRepository, 
        Request $request, 
        FlightsRepository $flightsRepository, 
        getFlightPricesInfo $flightPricesInfo,
    ): Response
    {
        $autosubmit = false;

        $needFlightsData = [];
        $classType = "";

        $params = $request->query->get('params');
        if ($params)
        {
            $autosubmit = true;
            $decodedParams = urldecode($params);
            parse_str($decodedParams, $paramsArray);

            $form = $this->createFormFromParams($paramsArray);
        } else {
            $form = $this->createForm(MainPageType::class);
        }

        $form->handleRequest($request);



        if (($form->isSubmitted() && $form->isValid()) || $autosubmit) {
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

    private function createFormFromParams(
        array $paramsArray,
    ): FormInterface
    {
        return $this->createForm(MainPageType::class, [
            'departureCity' => $this->citiesRepository->find($paramsArray['departureCityId']),
            'arrivalCity' => $this->citiesRepository->find($paramsArray['arrivalCityId']),
            'sheduledDeparture' => \DateTime::createFromFormat('Y-m-d', $paramsArray['sheduledDeparture']),
            'PersonCount' => (int) $paramsArray['PersonCount'],
            'ServisClass' => $this->getEnumFromString->getCompartmentTypeEnumFromString($paramsArray['ServisClass']['value']),
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
    ): Response
    {
        $needFlightsData = $flightsRepository->findNeedFlightsData($flightId);
        $needFlightsData = $flightPricesInfo->getFlightPricesInfo($needFlightsData , $classType);

        $seats = $entityManager->getRepository(FlightsSeats::class)->findBy(['flightId' => $flightId, 'compartmentType' => $classType],['id' => 'ASC'],);
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
        $ticketsData = json_decode($jsonString, true);

        $user = $this->getUser();
        if (!$user) {
            $this->addFlashNotise('Для совершения заказа требуется регистрация!');

        } elseif(!$user->isVerified()) {
            $this->addFlashNotise('Аккаунт должен быть подтвержден');
        } elseif (empty($ticketsData)) {
            $this->addFlashNotise('Заказ пуст!');
        } else {
            try {
                $orderPerformer->processTickets($ticketsData, $user, new \DateTime());
                $this->addFlashNotise('Билеты успешно приобретены!');

            } catch (\Exception $e) {
                $message = $e->getMessage();
                $this->addFlashNotise($message);
            }
        }

        // Предыдущая страница
        $referer = $request->headers->get('referer');
        return $this->redirect($referer);
    }

    private function addFlashNotise(string $message)
    {
        $this->addFlash('notice', $message);
    }
}
