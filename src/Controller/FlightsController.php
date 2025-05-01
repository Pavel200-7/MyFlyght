<?php

namespace App\Controller;

use App\Entity\Flights;
use App\Form\FlightsType;
use App\Repository\FlightsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/flights')]
final class FlightsController extends AbstractController
{
    #[Route(name: 'app_flights_index', methods: ['GET'])]
    public function index(FlightsRepository $flightsRepository): Response
    {
        return $this->render('flights/index.html.twig', [
            'flights' => $flightsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_flights_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $flight = new Flights();
        $form = $this->createForm(FlightsType::class, $flight);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($flight);
            $entityManager->flush();

            return $this->redirectToRoute('app_flights_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('flights/new.html.twig', [
            'flight' => $flight,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_flights_show', methods: ['GET'])]
    public function show(Flights $flight): Response
    {
        return $this->render('flights/show.html.twig', [
            'flight' => $flight,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_flights_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Flights $flight, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(FlightsType::class, $flight);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_flights_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('flights/edit.html.twig', [
            'flight' => $flight,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_flights_delete', methods: ['POST'])]
    public function delete(Request $request, Flights $flight, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$flight->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($flight);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_flights_index', [], Response::HTTP_SEE_OTHER);
    }
}
