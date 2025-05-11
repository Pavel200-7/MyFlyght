<?php

namespace App\Controller;

use App\Entity\Flights;
use App\Form\FlightsType;
use App\Repository\FlightsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/flights')]
final class FlightsController extends AbstractController
{
    #[Route(name: 'app_flights_index', methods: ['GET'])]
    public function index(FlightsRepository $flightsRepository): Response
    {
        return $this->render('airlinePanel/templates/flights/index.html.twig', [
            'flights' => $flightsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_flights_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, Security $security): Response
    {
        $airline = $security->getUser()->getAirlineId();

        $flight = new Flights();
        $flight->setAirliniID($airline);

        $form = $this->createForm(FlightsType::class, $flight, [
            'airline' => $airline,
        ]);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($flight);
            $entityManager->flush();

            return $this->redirectToRoute('app_flights_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('airlinePanel/templates/flights/new.html.twig', [
            'flight' => $flight,
            'form' => $form,
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

        return $this->render('airlinePanel/templates/flights/edit.html.twig', [
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
