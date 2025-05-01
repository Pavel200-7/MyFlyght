<?php

namespace App\Controller;

use App\Entity\Test2;
use App\Repository\Test2Repository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class TestInputController extends AbstractController
{
    #[Route('/testInput', name: 'app_test_input')]
    public function index(Test2Repository $test2repository , EntityManagerInterface $em): Response
    {
//        $test2 = $test2repository->findOneBy(['id'=>3]);
//        $test2->setTitle('Some title');
//        $em->flush();
        $test = $test2repository->findAll();
//        $test = $test2repository->findOneBy(['Title' => 'Some title']);
//        $em->remove($test);
//        $em->flush();
        dd($test);

//        $test = (new Test2())
//            ->setTitle("Первый заголовок")
//            ->setText("<UNK>Я что-то написал<UNK>");
//
//        $em->persist($test);
//        $em->flush();

        exit();

        return $this->render('test_input/index.html.twig', [
            'controller_name' => 'TestInputController',
        ]);
    }
}
