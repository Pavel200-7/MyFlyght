<?php

namespace App\Controller;

use App\Entity\SeatsDiscriptionShablon;
use App\Entity\SeatShablon;
use App\Enum\CompartmentTypeEnum;
use App\Form\SeatsDiscriptionShablonType;
use App\Repository\SeatsDiscriptionShablonRepository;
use App\Service\seatStructureClasses\seatStructure;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\seatStructureClasses\converterSeatsFromJSONtoArray;
use App\Service\seatStructureClasses\converterArrayToSeatsJSON;
use Symfony\Component\Serializer\SerializerInterface;


#[Route('/admin/seatsDiscriptionShablon')]
final class SeatsDiscriptionShablonController extends AbstractController
{
    #[Route(name: 'app_seats_discription_shablon_index', methods: ['GET'])]
    public function index(SeatsDiscriptionShablonRepository $seatsDiscriptionShablonRepository): Response
    {
        return $this->render('admin/templates/seats_discription_shablon/index.html.twig', [
            'seats_discription_shablons' => $seatsDiscriptionShablonRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_seats_discription_shablon_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer, converterSeatsFromJSONtoArray $converterSeatsFromJSONtoArray, converterArrayToSeatsJSON $arrayToSeatsJSON): Response
    {
        $seatsDiscriptionShablon = new SeatsDiscriptionShablon();
        $form = $this->createForm(SeatsDiscriptionShablonType::class, $seatsDiscriptionShablon);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($seatsDiscriptionShablon);
            $entityManager->flush();


            $seatsDiscriptionShablonNewJSON = $form->get('SeatShablonJSOn')->getData();
            $seatArray = $converterSeatsFromJSONtoArray->convert($seatsDiscriptionShablonNewJSON);

            foreach ($seatArray as $seatData)
            {
                $seat = new SeatShablon();
                $seat->setSeatShablon($seatsDiscriptionShablon);
                $seat->setCompartmentType($seatData['compartmentType']);
                $seat->setCompartmentNumber($seatData['compartmentNumber']);
                $seat->setZoneNumber($seatData['zoneNumber']);
                $seat->setSectorNumber($seatData['sectorNumber']);
                $seat->setRow($seatData['row']);
                $seat->setNumberInRow($seatData['seatNumber']);

                $entityManager->persist($seat);
                $entityManager->flush();
            }

            return $this->redirectToRoute('app_seats_discription_shablon_index', [], Response::HTTP_SEE_OTHER);
        }

        $seatStructure = new seatStructure();
        $classType = CompartmentTypeEnum::Economy->value;
        $seatStructure->addClass($classType);
        $seatStructure = $serializer->serialize($seatStructure, 'json');

        return $this->render('admin/templates/seats_discription_shablon/new.html.twig', [
            'seats_discription_shablon' => $seatsDiscriptionShablon,
            'form' => $form,
            'seatStructure' => $seatStructure,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_seats_discription_shablon_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, SeatsDiscriptionShablon $seatsDiscriptionShablon, EntityManagerInterface $entityManager, converterArrayToSeatsJSON $arrayToSeatsJSON, converterSeatsFromJSONtoArray $converterSeatsFromJSONtoArray): Response
    {
        $form = $this->createForm(SeatsDiscriptionShablonType::class, $seatsDiscriptionShablon);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $seats = $entityManager->getRepository(SeatShablon::class)->findBy(['SeatShablon' => $seatsDiscriptionShablon]);
            foreach ($seats as $seat)
            {
                $entityManager->remove($seat);
                $entityManager->flush();
            }

            $seatsDiscriptionShablonNewJSON = $form->get('SeatShablonJSOn')->getData();
            $seatArray = $converterSeatsFromJSONtoArray->convert($seatsDiscriptionShablonNewJSON);

            foreach ($seatArray as $seatData)
            {
                $seat = new SeatShablon();
                $seat->setSeatShablon($seatsDiscriptionShablon);
                $seat->setCompartmentType($seatData['compartmentType']);
                $seat->setCompartmentNumber($seatData['compartmentNumber']);
                $seat->setZoneNumber($seatData['zoneNumber']);
                $seat->setSectorNumber($seatData['sectorNumber']);
                $seat->setRow($seatData['row']);
                $seat->setNumberInRow($seatData['seatNumber']);

                $entityManager->persist($seat);
                $entityManager->flush();
            }

            return $this->redirectToRoute('app_seats_discription_shablon_index', [], Response::HTTP_SEE_OTHER);
        }

        $seats = $entityManager->getRepository(SeatShablon::class)->findBy(['SeatShablon' => $seatsDiscriptionShablon]);
        $seatStructure = $arrayToSeatsJSON->convert($seats);

        return $this->render('admin/templates/seats_discription_shablon/edit.html.twig', [
            'seats_discription_shablon' => $seatsDiscriptionShablon,
            'form' => $form,
            'seatStructure' => $seatStructure,
        ]);
    }

    #[Route('/{id}', name: 'app_seats_discription_shablon_delete', methods: ['POST'])]
    public function delete(Request $request, SeatsDiscriptionShablon $seatsDiscriptionShablon, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$seatsDiscriptionShablon->getId(), $request->getPayload()->getString('_token'))) {

            $seats = $entityManager->getRepository(SeatShablon::class)->findBy(['SeatShablon' => $seatsDiscriptionShablon]);
            foreach ($seats as $seat)
            {
                $entityManager->remove($seat);
                $entityManager->flush();
            }
            
            $entityManager->remove($seatsDiscriptionShablon);
            $entityManager->flush();


        }

        return $this->redirectToRoute('app_seats_discription_shablon_index', [], Response::HTTP_SEE_OTHER);
    }
}
