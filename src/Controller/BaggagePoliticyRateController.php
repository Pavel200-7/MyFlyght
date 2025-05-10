<?php

namespace App\Controller;

use App\Entity\BaggagePoliticyRate;
use App\Form\BaggagePoliticyRateType;
use App\Repository\BaggagePoliticyRateRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/airlinePanel/baggagePoliticyRate')]
final class BaggagePoliticyRateController extends AbstractController
{
    #[Route(name: 'app_baggage_politicy_rate_index', methods: ['GET'])]
    public function index(BaggagePoliticyRateRepository $baggagePoliticyRateRepository): Response
    {
        return $this->render('airlinePanel/templates/baggage_politicy_rate/index.html.twig', [
            'baggage_politicy_rates' => $baggagePoliticyRateRepository->findAll(),
        ]);
    }

    #[Route('/{id}/edit', name: 'app_baggage_politicy_rate_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, BaggagePoliticyRate $baggagePoliticyRate, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BaggagePoliticyRateType::class, $baggagePoliticyRate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_baggage_politicy_rate_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('airlinePanel/templates/baggage_politicy_rate/edit.html.twig', [
            'baggage_politicy_rate' => $baggagePoliticyRate,
            'form' => $form,
        ]);
    }
}
