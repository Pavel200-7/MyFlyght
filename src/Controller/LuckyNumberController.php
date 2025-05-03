<?php

namespace App\Controller;

use App\Message\SendLuckyNumber;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Messenger\MessageBusInterface;

final class LuckyNumberController extends AbstractController
{
    /**
     * @throws TransportExceptionInterface
     */
    #[Route('/luckyNumber', name: 'app_lucky_number')]
    public function index(MessageBusInterface $bus): Response
    {
        $luckyNumber = random_int(0, 100);
//        $to = 'pavlik.yakovlev.2000makron@mail.ru';
//        $bus->dispatch(new SendLuckyNumber($to, $luckyNumber));


        return $this->render('lucky_number/index.html.twig', [
            'controller_name' => 'LuckyNumberController',
            'luckyNumber' => $luckyNumber,
        ]);
    }
}
