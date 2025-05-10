<?php

namespace App\Controller;

use App\Entity\PlaneClassRate;
use App\Form\PlaneClassRateType;
use App\Repository\AircraftRepository;
use App\Repository\AirlineRepository;
use App\Repository\PlaneClassRateRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/airlinePanel/planeClassRate')]
final class PlaneClassRateController extends AbstractController
{
    #[Route(name: 'app_plane_class_rate_index', methods: ['GET'])]
    public function index(PlaneClassRateRepository $planeClassRateRepository, Security $security, AirlineRepository $airlineRepository): Response
    {
        $airline = $security->getUser()->getAirlineId();

        return $this->render('airlinePanel/templates/plane_class_rate/index.html.twig', [
            'plane_class_rates' => $planeClassRateRepository->findBy(['airlineID' => $airline]),
        ]);
    }


    #[Route('/{id}/edit', name: 'app_plane_class_rate_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, PlaneClassRate $planeClassRate, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PlaneClassRateType::class, $planeClassRate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_plane_class_rate_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('airlinePanel/templates/plane_class_rate/edit.html.twig', [
            'plane_class_rate' => $planeClassRate,
            'form' => $form,
        ]);
    }

}
