<?php

namespace App\Controller;

use App\Entity\SeatsDiscriptionShablon;
use App\Form\SeatsDiscriptionShablonType;
use App\Repository\SeatsDiscriptionShablonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/seatsDiscriptionShablon')]
final class SeatsDiscriptionShablonController extends AbstractController
{
    #[Route(name: 'app_seats_discription_shablon_index', methods: ['GET'])]
    public function index(SeatsDiscriptionShablonRepository $seatsDiscriptionShablonRepository): Response
    {
        return $this->render('seats_discription_shablon/index.html.twig', [
            'seats_discription_shablons' => $seatsDiscriptionShablonRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_seats_discription_shablon_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $seatsDiscriptionShablon = new SeatsDiscriptionShablon();
        $form = $this->createForm(SeatsDiscriptionShablonType::class, $seatsDiscriptionShablon);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($seatsDiscriptionShablon);
            $entityManager->flush();

            return $this->redirectToRoute('app_seats_discription_shablon_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('seats_discription_shablon/new.html.twig', [
            'seats_discription_shablon' => $seatsDiscriptionShablon,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_seats_discription_shablon_show', methods: ['GET'])]
    public function show(SeatsDiscriptionShablon $seatsDiscriptionShablon): Response
    {
        return $this->render('seats_discription_shablon/show.html.twig', [
            'seats_discription_shablon' => $seatsDiscriptionShablon,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_seats_discription_shablon_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, SeatsDiscriptionShablon $seatsDiscriptionShablon, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SeatsDiscriptionShablonType::class, $seatsDiscriptionShablon);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_seats_discription_shablon_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('seats_discription_shablon/edit.html.twig', [
            'seats_discription_shablon' => $seatsDiscriptionShablon,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_seats_discription_shablon_delete', methods: ['POST'])]
    public function delete(Request $request, SeatsDiscriptionShablon $seatsDiscriptionShablon, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$seatsDiscriptionShablon->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($seatsDiscriptionShablon);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_seats_discription_shablon_index', [], Response::HTTP_SEE_OTHER);
    }
}
