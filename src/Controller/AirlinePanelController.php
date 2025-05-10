<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AirlinePanelController extends AbstractController
{
    #[Route('/airlinePanel', name: 'app_airlinePanel')]
    public function index(): Response
    {
        return $this->render('airlinePanel/index.html.twig', [
            'controller_name' => 'AirlinePanelController',
        ]);
    }
}
