<?php

namespace App\Controller;

use App\Entity\FlightsSeats;
use App\Form\FlightsSeatsType;
use App\Repository\FlightsSeatsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/flightsSeats')]
final class FlightsSeatsController extends AbstractController
{
    #[Route(name: 'app_flights_seats_index', methods: ['GET'])]
    public function index(FlightsSeatsRepository $flightsSeatsRepository): Response
    {
        return $this->render('flights_seats/index.html.twig', [
            'flights_seats' => $flightsSeatsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_flights_seats_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $flightsSeat = new FlightsSeats();
        $form = $this->createForm(FlightsSeatsType::class, $flightsSeat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($flightsSeat);
            $entityManager->flush();

            return $this->redirectToRoute('app_flights_seats_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('flights_seats/new.html.twig', [
            'flights_seat' => $flightsSeat,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_flights_seats_show', methods: ['GET'])]
    public function show(FlightsSeats $flightsSeat): Response
    {
        return $this->render('flights_seats/show.html.twig', [
            'flights_seat' => $flightsSeat,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_flights_seats_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, FlightsSeats $flightsSeat, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(FlightsSeatsType::class, $flightsSeat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_flights_seats_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('flights_seats/edit.html.twig', [
            'flights_seat' => $flightsSeat,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_flights_seats_delete', methods: ['POST'])]
    public function delete(Request $request, FlightsSeats $flightsSeat, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$flightsSeat->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($flightsSeat);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_flights_seats_index', [], Response::HTTP_SEE_OTHER);
    }
}
