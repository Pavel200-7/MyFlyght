<?php

namespace App\Controller;

use App\Entity\SeatShablon;
use App\Form\SeatShablonType;
use App\Repository\SeatShablonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/seatShablon')]
final class SeatShablonController extends AbstractController
{
    #[Route(name: 'app_seat_shablon_index', methods: ['GET'])]
    public function index(SeatShablonRepository $seatShablonRepository): Response
    {
        return $this->render('seat_shablon/index.html.twig', [
            'seat_shablons' => $seatShablonRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_seat_shablon_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $seatShablon = new SeatShablon();
        $form = $this->createForm(SeatShablonType::class, $seatShablon);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($seatShablon);
            $entityManager->flush();

            return $this->redirectToRoute('app_seat_shablon_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('seat_shablon/new.html.twig', [
            'seat_shablon' => $seatShablon,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_seat_shablon_show', methods: ['GET'])]
    public function show(SeatShablon $seatShablon): Response
    {
        return $this->render('seat_shablon/show.html.twig', [
            'seat_shablon' => $seatShablon,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_seat_shablon_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, SeatShablon $seatShablon, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SeatShablonType::class, $seatShablon);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_seat_shablon_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('seat_shablon/edit.html.twig', [
            'seat_shablon' => $seatShablon,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_seat_shablon_delete', methods: ['POST'])]
    public function delete(Request $request, SeatShablon $seatShablon, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$seatShablon->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($seatShablon);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_seat_shablon_index', [], Response::HTTP_SEE_OTHER);
    }
}
