<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class DefaultController extends AbstractController
{
    #[Route('/default/{id}', name: 'app_default', requirements: ['id'=>'\d+'], defaults: ['id'=>1], methods: ['GET'])]
    public function index(Request $request, int $id): Response
    {
//        dd($request->query->get('name'));
        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
            'id' => $id,
        ]);
    }
}
