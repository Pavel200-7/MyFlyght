<?php

namespace App\Controller;

use App\Entity\BaggagePoliticy;
use App\Form\BaggagePoliticyType;
use App\Repository\BaggagePoliticyRepository;
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
        return $this->render('baggage_politicy/index.html.twig', [
            'baggage_politicies' => $baggagePoliticyRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_baggage_politicy_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $baggagePoliticy = new BaggagePoliticy();
        $form = $this->createForm(BaggagePoliticyType::class, $baggagePoliticy);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($baggagePoliticy);
            $entityManager->flush();

            return $this->redirectToRoute('app_baggage_politicy_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('baggage_politicy/new.html.twig', [
            'baggage_politicy' => $baggagePoliticy,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_baggage_politicy_show', methods: ['GET'])]
    public function show(BaggagePoliticy $baggagePoliticy): Response
    {
        return $this->render('baggage_politicy/show.html.twig', [
            'baggage_politicy' => $baggagePoliticy,
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

        return $this->render('baggage_politicy/edit.html.twig', [
            'baggage_politicy' => $baggagePoliticy,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_baggage_politicy_delete', methods: ['POST'])]
    public function delete(Request $request, BaggagePoliticy $baggagePoliticy, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$baggagePoliticy->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($baggagePoliticy);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_baggage_politicy_index', [], Response::HTTP_SEE_OTHER);
    }
}
