<?php

namespace App\Controller;

use App\Entity\Tickets;
use App\Form\MainPageType;
use App\Form\TicketsType;
use App\Repository\FlightsRepository;
use App\Repository\TicketsRepository;
use App\Service\flightFinder;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/tickets')]
final class TicketsController extends AbstractController
{
    #[Route(name: 'app_tickets_index', methods: ['GET', 'POST'])]
    public function index(TicketsRepository $ticketsRepository, Request $request, FlightsRepository $flightsRepository): Response
    {
        $form = $this->createForm(MainPageType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $needFlightsID = $flightsRepository->findNeedFlightsID($form);
            dd($needFlightsID);
            // Далее нужно преобразовать id в информацию о рейсах и прописать их отрисовку в templates.
        }

        return $this->render('tickets/index.html.twig', [
            'tickets' => $ticketsRepository->findAll(),
            'form' => $form,
        ]);
    }
}
