<?php

namespace App\Controller;

use App\Entity\HundLuggagePoliticy;
use App\Form\HundLuggagePoliticyType;
use App\Repository\HundLuggagePoliticyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/hundLuggagePoliticy')]
final class HundLuggagePoliticyController extends AbstractController
{
    #[Route(name: 'app_hund_luggage_politicy_index', methods: ['GET'])]
    public function index(HundLuggagePoliticyRepository $hundLuggagePoliticyRepository): Response
    {
        return $this->render('hund_luggage_politicy/index.html.twig', [
            'hund_luggage_politicies' => $hundLuggagePoliticyRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_hund_luggage_politicy_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $hundLuggagePoliticy = new HundLuggagePoliticy();
        $form = $this->createForm(HundLuggagePoliticyType::class, $hundLuggagePoliticy);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($hundLuggagePoliticy);
            $entityManager->flush();

            return $this->redirectToRoute('app_hund_luggage_politicy_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('hund_luggage_politicy/new.html.twig', [
            'hund_luggage_politicy' => $hundLuggagePoliticy,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_hund_luggage_politicy_show', methods: ['GET'])]
    public function show(HundLuggagePoliticy $hundLuggagePoliticy): Response
    {
        return $this->render('hund_luggage_politicy/show.html.twig', [
            'hund_luggage_politicy' => $hundLuggagePoliticy,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_hund_luggage_politicy_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, HundLuggagePoliticy $hundLuggagePoliticy, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(HundLuggagePoliticyType::class, $hundLuggagePoliticy);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_hund_luggage_politicy_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('hund_luggage_politicy/edit.html.twig', [
            'hund_luggage_politicy' => $hundLuggagePoliticy,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_hund_luggage_politicy_delete', methods: ['POST'])]
    public function delete(Request $request, HundLuggagePoliticy $hundLuggagePoliticy, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$hundLuggagePoliticy->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($hundLuggagePoliticy);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_hund_luggage_politicy_index', [], Response::HTTP_SEE_OTHER);
    }
}
