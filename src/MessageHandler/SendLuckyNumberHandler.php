<?php

namespace App\MessageHandler;

use App\Message\SendLuckyNumber;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Mime\Email;

#[AsMessageHandler]
class SendLuckyNumberHandler
{
    /**
     * @throws TransportExceptionInterface
     */

    public function __construct(
        private MailerInterface $mailer,
    ){
    }
    public function __invoke(SendLuckyNumber $sendLuckyNumber){
        $mail = (New Email())
            ->from('pavel.yakovlev.2000makron@gmail.com')
            ->to($sendLuckyNumber->getTo())
            ->subject('Lucky Number')
            ->text((string) $sendLuckyNumber->getLuckyNumber());

        $this->mailer->send($mail);

    }
}
