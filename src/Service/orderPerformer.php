<?php

namespace App\Service;

use App\Entity\FlightsSeats;
use App\Entity\Tickets;
use Doctrine\ORM\EntityManagerInterface;

class orderPerformer
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function processTickets(array $ticketsInfo, $user, \DateTimeInterface $now): void
    {
        $this->em->getConnection()->beginTransaction();

        try {
            foreach ($ticketsInfo as $seatId => $haveBaggage) {
                // Получая место
                $seat = $this->em->find(FlightsSeats::class, $seatId);

                if (!$seat) {
                    throw new \Exception("Место с ID {$seatId} не найдено");
                }

                // Проверка доступности
                if ($seat->isAvalible() !== true) {

                    throw new \Exception("Место с ID {$seatId} уже забронировано");
                }

                // Обновление статуса места
                $seat->setAvalible(false);
                $this->em->persist($seat);

                // Создаем билет
                $ticket = new Tickets();
                $ticket->setFlightSeatsId($seat);
                $ticket->setClientId($user); // Передать объект пользователя или ID, зависит от Entity
                $ticket->setBaggage($haveBaggage);
                $ticket->setTimestamp($now);

                $this->em->persist($ticket);
            }

            $this->em->flush();
            $this->em->getConnection()->commit();

        } catch (\Exception $e) {
            $this->em->getConnection()->rollBack();
            throw $e; // Или обработка
        }
    }
}