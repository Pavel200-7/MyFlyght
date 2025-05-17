<?php

namespace App\Controller;

use App\Entity\Flights;
use App\Entity\FlightsSeats;
use App\Entity\SeatShablon;
use App\Form\FlightsType;
use App\Repository\FlightsRepository;
use App\Service\getEnumFromString;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/flights')]
final class FlightsController extends AbstractController
{
    #[Route(name: 'app_flights_index', methods: ['GET'])]
    public function index(FlightsRepository $flightsRepository, Security $security): Response
    {
        $airline = $security->getUser()->getAirlineId();

        return $this->render('airlinePanel/templates/flights/index.html.twig', [
            'flights' => $flightsRepository->findBy(['airliniID' => $airline]),
        ]);
    }

    #[Route('/new', name: 'app_flights_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, Security $security, ValidatorInterface $validator, getEnumFromString $enumFromString): Response
    {
        $airline = $security->getUser()->getAirlineId();

        $flight = new Flights();
        $flight->setAirliniID($airline);
        $flight->setFinished(false);


        $form = $this->createForm(FlightsType::class, $flight, [
            'airline' => $airline,
        ]);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $errors = $validator->validate($flight);
            if (count($errors) > 0) {
                foreach ($errors as $error) {
                    $form->get($error->getPropertyPath())->addError(new FormError($error->getMessage()));
                }
                // Не сохраняем, возвращаемся к форме
                return $this->render('airlinePanel/templates/flights/new.html.twig', [
                    'flight' => $flight,
                    'form' => $form,
                ]);
            }
            // Если ошибок нет, сохраняем
            $entityManager->persist($flight);
            $entityManager->flush();

            $seatsDiscriptionShablon = $flight->getAircraftId()->getAircraftModelId()->getSeatsDiscriptionId();
            $seats = $entityManager->getRepository(SeatShablon::class)->findBy(['SeatShablon' => $seatsDiscriptionShablon]);
            foreach ($seats as $seatData)
            {
                $flightSeat = new FlightsSeats();
                $flightSeat->setFlightId($flight);
                $flightSeat->setCompartmentNumber($seatData->getCompartmentNumber());
                $flightSeat->setCompartmentType($enumFromString->getCompartmentTypeEnumFromString($seatData->getCompartmentType()));
                $flightSeat->setZoneNumber($seatData->getZoneNumber());
                $flightSeat->setSectorNumber($seatData->getSectorNumber());
                $flightSeat->setRow($seatData->getRow());
                $flightSeat->setNumberInRow($seatData->getNumberInRow());
                $flightSeat->setAvalible(true);

                $entityManager->persist($flightSeat);
                $entityManager->flush();
            }



            return $this->redirectToRoute('app_flights_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('airlinePanel/templates/flights/new.html.twig', [
            'flight' => $flight,
            'form' => $form,
        ]);
    }


    #[Route('/{id}/edit', name: 'app_flights_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Flights $flight, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(FlightsType::class, $flight);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_flights_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('airlinePanel/templates/flights/edit.html.twig', [
            'flight' => $flight,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_flights_delete', methods: ['POST'])]
    public function delete(Request $request, Flights $flight, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$flight->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($flight);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_flights_index', [], Response::HTTP_SEE_OTHER);
    }
}
