<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class MainPageController extends AbstractController
{
    #[Route('/mainPage', name: 'app_main_page')]
    public function index(): Response
    {


        $Cyties = ["Севастополь", "Москва",];


        return $this->render('main_page/index.html.twig', [
            'controller_name' => 'MainPageController',
            'Cyties' => $Cyties,
        ]);
    }
}
