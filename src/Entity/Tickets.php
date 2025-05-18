<?php

namespace App\Entity;

use App\Repository\TicketsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TicketsRepository::class)]
class Tickets
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: FlightsSeats::class)]
    #[ORM\JoinColumn(name: 'FlightsSeats_id', referencedColumnName: 'id')]

    private FlightsSeats|null $flightSeatsId = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'User_id', referencedColumnName: 'id')]
    private User|null $clientId = null;

    #[ORM\Column]
    private ?bool $baggage = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $timestamp = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFlightSeatsId(): ?FlightsSeats
    {
        return $this->flightSeatsId;
    }

    public function setFlightSeatsId(FlightsSeats $flightSeatsId): static
    {
        $this->flightSeatsId = $flightSeatsId;

        return $this;
    }

    public function getClientId(): ?User
    {
        return $this->clientId;
    }

    public function setClientId(User $clientId): static
    {
        $this->clientId = $clientId;

        return $this;
    }

    public function getBaggage(): ?bool
    {
        return $this->baggage;
    }

    public function setBaggage(?bool $baggage): static
    {
        $this->baggage = $baggage;

        return $this;
    }



    public function getTimestamp(): ?\DateTimeInterface
    {
        return $this->timestamp;
    }

    public function setTimestamp(?\DateTimeInterface $timestamp): static
    {
        $this->timestamp = $timestamp;

        return $this;
    }
}
