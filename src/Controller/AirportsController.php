<?php

namespace App\Controller;

use App\Entity\Airports;
use App\Form\AirportsType;
use App\Repository\AirportsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/airports')]
final class AirportsController extends AbstractController
{
    #[Route(name: 'app_airports_index', methods: ['GET'])]
    public function index(AirportsRepository $airportsRepository): Response
    {
        return $this->render('airports/index.html.twig', [
            'airports' => $airportsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_airports_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $airport = new Airports();
        $form = $this->createForm(AirportsType::class, $airport);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($airport);
            $entityManager->flush();

            return $this->redirectToRoute('app_airports_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('airports/new.html.twig', [
            'airport' => $airport,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_airports_show', methods: ['GET'])]
    public function show(Airports $airport): Response
    {
        return $this->render('airports/show.html.twig', [
            'airport' => $airport,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_airports_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Airports $airport, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AirportsType::class, $airport);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_airports_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('airports/edit.html.twig', [
            'airport' => $airport,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_airports_delete', methods: ['POST'])]
    public function delete(Request $request, Airports $airport, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$airport->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($airport);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_airports_index', [], Response::HTTP_SEE_OTHER);
    }
}
