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

    #[ORM\ManyToOne(targetEntity: Flights::class)]
    #[ORM\JoinColumn(name: 'Flights_id', referencedColumnName: 'id')]
    private Flights|null $flightId = null;


    #[ORM\ManyToOne(targetEntity: FlightsSeats::class)]
    #[ORM\JoinColumn(name: 'FlightsSeats_id', referencedColumnName: 'id')]

    private FlightsSeats|null $flightSeatsId = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'User_id', referencedColumnName: 'id')]
    private User|null $clientId = null;

    #[ORM\Column]
    private ?bool $finished = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $timestamp = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFlightId(): ?int
    {
        return $this->flightId;
    }

    public function setFlightId(int $flightId): static
    {
        $this->flightId = $flightId;

        return $this;
    }

    public function getFlightSeatsId(): ?int
    {
        return $this->flightSeatsId;
    }

    public function setFlightSeatsId(int $flightSeatsId): static
    {
        $this->flightSeatsId = $flightSeatsId;

        return $this;
    }

    public function getClientId(): ?int
    {
        return $this->clientId;
    }

    public function setClientId(int $clientId): static
    {
        $this->clientId = $clientId;

        return $this;
    }

    public function isFinished(): ?bool
    {
        return $this->finished;
    }

    public function setFinished(bool $finished): static
    {
        $this->finished = $finished;

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
