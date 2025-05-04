<?php

namespace App\Controller;

use App\Entity\Manufacturers;
use App\Form\ManufacturersType;
use App\Repository\ManufacturersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/manufacturers')]
final class ManufacturersController extends AbstractController
{
    #[Route(name: 'app_manufacturers_index', methods: ['GET'])]
    public function index(ManufacturersRepository $manufacturersRepository): Response
    {
        return $this->render('manufacturers/index.html.twig', [
            'manufacturers' => $manufacturersRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_manufacturers_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $manufacturer = new Manufacturers();
        $form = $this->createForm(ManufacturersType::class, $manufacturer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($manufacturer);
            $entityManager->flush();

            return $this->redirectToRoute('app_manufacturers_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('manufacturers/new.html.twig', [
            'manufacturer' => $manufacturer,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_manufacturers_show', methods: ['GET'])]
    public function show(Manufacturers $manufacturer): Response
    {
        return $this->render('manufacturers/show.html.twig', [
            'manufacturer' => $manufacturer,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_manufacturers_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Manufacturers $manufacturer, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ManufacturersType::class, $manufacturer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_manufacturers_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('manufacturers/edit.html.twig', [
            'manufacturer' => $manufacturer,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_manufacturers_delete', methods: ['POST'])]
    public function delete(Request $request, Manufacturers $manufacturer, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$manufacturer->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($manufacturer);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_manufacturers_index', [], Response::HTTP_SEE_OTHER);
    }
}
