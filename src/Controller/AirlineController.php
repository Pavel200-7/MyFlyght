<?php

namespace App\Controller;

use App\Entity\Airline;
use App\Form\AirlineType;
use App\Repository\AirlineRepository;
use App\Service\baggagePoliticyRateWorker;
use App\Service\planeClassRateWorker;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
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
        return $this->render('admin/templates/airline/index.html.twig', [
            'airlines' => $airlineRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_airline_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, planeClassRateWorker $planeClassRateWorker, baggagePoliticyRateWorker $baggagePoliticyRateWorker): Response
    {
        $airline = new Airline();
        $form = $this->createForm(AirlineType::class, $airline);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($airline);
            $entityManager->flush();

            $planeClassRateWorker->createPlaneClassRateNotes($airline);
            $baggagePoliticyRateWorker->createBaggagePoliticesRateNotes($airline);

            return $this->redirectToRoute('app_airline_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/templates/airline/new.html.twig', [
            'airline' => $airline,
            'form' => $form,
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

        return $this->render('admin/templates/airline/edit.html.twig', [
            'airline' => $airline,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_airline_delete', methods: ['POST'])]
    public function delete(Request $request, Airline $airline, EntityManagerInterface $entityManager, planeClassRateWorker $planeClassRateWorker, baggagePoliticyRateWorker $baggagePoliticyRateWorker): Response
    {
        if ($this->isCsrfTokenValid('delete'.$airline->getId(), $request->getPayload()->getString('_token'))) {

            $planeClassRateWorker->deletePlaneClassForAirline($airline);
            $baggagePoliticyRateWorker->deleteBaggagePoliticeForAirline($airline);

            $entityManager->remove($airline);
            $entityManager->flush();

        }

        return $this->redirectToRoute('app_airline_index', [], Response::HTTP_SEE_OTHER);
    }
}
