<?php

namespace App\Controller;

use App\Entity\BaggagePoliticy;
use App\Form\BaggagePoliticyType;
use App\Repository\BaggagePoliticyRepository;
use App\Service\baggagePoliticyRateWorker;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/baggagePoliticy')]
final class BaggagePoliticyController extends AbstractController
{
    #[Route(name: 'app_baggage_politicy_index', methods: ['GET'])]
    public function index(BaggagePoliticyRepository $baggagePoliticyRepository): Response
    {
        return $this->render('admin/templates/baggage_politicy/index.html.twig', [
            'baggage_politicies' => $baggagePoliticyRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_baggage_politicy_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, baggagePoliticyRateWorker $baggagePoliticyRateWorker): Response
    {
        $baggagePoliticy = new BaggagePoliticy();
        $form = $this->createForm(BaggagePoliticyType::class, $baggagePoliticy);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($baggagePoliticy);
            $entityManager->flush();

            $baggagePoliticyRateWorker->createNewBaggagePoliticesRateNote($baggagePoliticy);

            return $this->redirectToRoute('app_baggage_politicy_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/templates/baggage_politicy/new.html.twig', [
            'baggage_politicy' => $baggagePoliticy,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_baggage_politicy_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, BaggagePoliticy $baggagePoliticy, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BaggagePoliticyType::class, $baggagePoliticy);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_baggage_politicy_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/templates/baggage_politicy/edit.html.twig', [
            'baggage_politicy' => $baggagePoliticy,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_baggage_politicy_delete', methods: ['POST'])]
    public function delete(Request $request, BaggagePoliticy $baggagePoliticy, EntityManagerInterface $entityManager, baggagePoliticyRateWorker $baggagePoliticyRateWorker): Response
    {
        if ($this->isCsrfTokenValid('delete'.$baggagePoliticy->getId(), $request->getPayload()->getString('_token'))) {
            $baggagePoliticyRateWorker->deleteBaggagePolitice($baggagePoliticy);
            $entityManager->remove($baggagePoliticy);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_baggage_politicy_index', [], Response::HTTP_SEE_OTHER);
    }
}
