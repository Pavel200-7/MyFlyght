<?php

namespace App\Controller;

use App\Entity\AircraftModel;
use App\Form\AircraftModel1Type;
use App\Repository\AircraftModelRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/aircraftModel')]
final class AircraftModelController extends AbstractController
{
    #[Route(name: 'app_aircraft_model_index', methods: ['GET'])]
    public function index(AircraftModelRepository $aircraftModelRepository): Response
    {
        return $this->render('aircraft_model/index.html.twig', [
            'aircraft_models' => $aircraftModelRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_aircraft_model_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $aircraftModel = new AircraftModel();
        $form = $this->createForm(AircraftModel1Type::class, $aircraftModel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($aircraftModel);
            $entityManager->flush();

            return $this->redirectToRoute('app_aircraft_model_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('aircraft_model/new.html.twig', [
            'aircraft_model' => $aircraftModel,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_aircraft_model_show', methods: ['GET'])]
    public function show(AircraftModel $aircraftModel): Response
    {
        return $this->render('aircraft_model/show.html.twig', [
            'aircraft_model' => $aircraftModel,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_aircraft_model_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, AircraftModel $aircraftModel, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AircraftModel1Type::class, $aircraftModel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_aircraft_model_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('aircraft_model/edit.html.twig', [
            'aircraft_model' => $aircraftModel,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_aircraft_model_delete', methods: ['POST'])]
    public function delete(Request $request, AircraftModel $aircraftModel, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$aircraftModel->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($aircraftModel);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_aircraft_model_index', [], Response::HTTP_SEE_OTHER);
    }
}
