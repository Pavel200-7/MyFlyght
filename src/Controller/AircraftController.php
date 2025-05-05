<?php

namespace App\Controller;

use App\Entity\Aircraft;
use App\Form\AircraftType;
use App\Repository\AircraftRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/aircraft')]
final class AircraftController extends AbstractController
{
    #[Route(name: 'app_aircraft_index', methods: ['GET'])]
    public function index(AircraftRepository $aircraftRepository): Response
    {
        return $this->render('admin/templates/aircraft/index.html.twig', [
            'aircraft' => $aircraftRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_aircraft_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $aircraft = new Aircraft();
        $form = $this->createForm(AircraftType::class, $aircraft);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($aircraft);
            $entityManager->flush();

            return $this->redirectToRoute('app_aircraft_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/templates/aircraft/new.html.twig', [
            'aircraft' => $aircraft,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_aircraft_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Aircraft $aircraft, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AircraftType::class, $aircraft);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

//            dd($form->getData());

            return $this->redirectToRoute('app_aircraft_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/templates/aircraft/edit.html.twig', [
            'aircraft' => $aircraft,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_aircraft_delete', methods: ['POST'])]
    public function delete(Request $request, Aircraft $aircraft, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$aircraft->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($aircraft);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_aircraft_index', [], Response::HTTP_SEE_OTHER);
    }
}
