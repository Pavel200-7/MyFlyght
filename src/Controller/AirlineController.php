<?php

namespace App\Controller;

use App\Entity\Airline;
use App\Form\AirlineType;
use App\Repository\AirlineRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/airline')]
final class AirlineController extends AbstractController
{
    #[Route(name: 'app_airline_index', methods: ['GET'])]
    public function index(AirlineRepository $airlineRepository): Response
    {
        return $this->render('airline/index.html.twig', [
            'airlines' => $airlineRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_airline_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $airline = new Airline();
        $form = $this->createForm(AirlineType::class, $airline);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($airline);
            $entityManager->flush();

            return $this->redirectToRoute('app_airline_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('airline/new.html.twig', [
            'airline' => $airline,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_airline_show', methods: ['GET'])]
    public function show(Airline $airline): Response
    {
        return $this->render('airline/show.html.twig', [
            'airline' => $airline,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_airline_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Airline $airline, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AirlineType::class, $airline);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_airline_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('airline/edit.html.twig', [
            'airline' => $airline,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_airline_delete', methods: ['POST'])]
    public function delete(Request $request, Airline $airline, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$airline->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($airline);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_airline_index', [], Response::HTTP_SEE_OTHER);
    }
}
