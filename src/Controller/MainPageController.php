<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\MainPageType;



final class MainPageController extends AbstractController
{
//    #[Route('/mainPage', name: 'app_main_page')]
    #[Route('/', name: 'app_main_page')]

    public function index(Request $request, Security $security): Response
    {
        $form = $this->createForm(MainPageType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            dd($form->getData());
        }

        $isAdmin = $security->isGranted('ROLE_ADMIN');
        $isAirline = $security->isGranted('ROLE_AIRLINE');


        return $this->render('main_page/index.html.twig', [
            'controller_name' => 'MainPageController',
            'form' => $form,
            'isAdmin' => $isAdmin,
            'isAirline' => $isAirline,
        ]);
    }
}
