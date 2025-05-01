<?php

namespace App\Entity;

use App\Repository\FlightsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FlightsRepository::class)]
class Flights
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $sheduledDeparture = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $sheduledArrival = null;

    #[ORM\ManyToOne(targetEntity: Airports::class)]
    #[ORM\JoinColumn(name: 'Airports_id', referencedColumnName: 'id')]
    private Airports|null $departureAirport = null;

    #[ORM\ManyToOne(targetEntity: Airports::class)]
    #[ORM\JoinColumn(name: 'Airports_id', referencedColumnName: 'id')]
    private Airports|null $arrivalAirport = null;

    #[ORM\Column]
    private ?bool $finished = null;

    #[ORM\ManyToOne(targetEntity: Aircraft::class)]
    #[ORM\JoinColumn(name: 'Aircraft_id', referencedColumnName: 'id')]
    private Aircraft|null $aircraftId = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $actualDeparture = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $actualArrival = null;

    #[ORM\ManyToOne(targetEntity: Airline::class)]
    #[ORM\JoinColumn(name: 'Airline_id', referencedColumnName: 'id')]
    private Airline|null $airliniID = null;

    #[ORM\ManyToOne(targetEntity: HundLuggagePoliticy::class)]
    #[ORM\JoinColumn(name: 'HundLuggagePoliticy_id', referencedColumnName: 'id')]
    private HundLuggagePoliticy|null $handLuggagePoliticyID = null;

    #[ORM\ManyToOne(targetEntity: BaggagePoliticy::class)]
    #[ORM\JoinColumn(name: 'BaggagePoliticy_id', referencedColumnName: 'id')]
    private BaggagePoliticy|null $baggagePoliticyID = null;

    #[ORM\Column(length: 10)]
    private ?string $flightNumber = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSheduledDeparture(): ?\DateTimeInterface
    {
        return $this->sheduledDeparture;
    }

    public function setSheduledDeparture(\DateTimeInterface $sheduledDeparture): static
    {
        $this->sheduledDeparture = $sheduledDeparture;

        return $this;
    }

    public function getSheduledArrival(): ?\DateTimeInterface
    {
        return $this->sheduledArrival;
    }

    public function setSheduledArrival(\DateTimeInterface $sheduledArrival): static
    {
        $this->sheduledArrival = $sheduledArrival;

        return $this;
    }

    public function getDepartureAirport(): ?int
    {
        return $this->departureAirport;
    }

    public function setDepartureAirport(int $departureAirport): static
    {
        $this->departureAirport = $departureAirport;

        return $this;
    }

    public function getArrivalAirport(): ?\DateTimeInterface
    {
        return $this->arrivalAirport;
    }

    public function setArrivalAirport(\DateTimeInterface $arrivalAirport): static
    {
        $this->arrivalAirport = $arrivalAirport;

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

    public function getAircraftId(): ?int
    {
        return $this->aircraftId;
    }

    public function setAircraftId(int $aircraftId): static
    {
        $this->aircraftId = $aircraftId;

        return $this;
    }

    public function getActualDeparture(): ?\DateTimeInterface
    {
        return $this->actualDeparture;
    }

    public function setActualDeparture(\DateTimeInterface $actualDeparture): static
    {
        $this->actualDeparture = $actualDeparture;

        return $this;
    }

    public function getActualArrival(): ?\DateTimeInterface
    {
        return $this->actualArrival;
    }

    public function setActualArrival(\DateTimeInterface $actualArrival): static
    {
        $this->actualArrival = $actualArrival;

        return $this;
    }

    public function getAirliniID(): ?int
    {
        return $this->airliniID;
    }

    public function setAirliniID(int $airliniID): static
    {
        $this->airliniID = $airliniID;

        return $this;
    }

    public function getHandLuggagePoliticyID(): ?int
    {
        return $this->handLuggagePoliticyID;
    }

    public function setHandLuggagePoliticyID(int $handLuggagePoliticyID): static
    {
        $this->handLuggagePoliticyID = $handLuggagePoliticyID;

        return $this;
    }

    public function getBaggagePoliticyID(): ?int
    {
        return $this->baggagePoliticyID;
    }

    public function setBaggagePoliticyID(int $baggagePoliticyID): static
    {
        $this->baggagePoliticyID = $baggagePoliticyID;

        return $this;
    }

    public function getFlightNumber(): ?string
    {
        return $this->flightNumber;
    }

    public function setFlightNumber(string $flightNumber): static
    {
        $this->flightNumber = $flightNumber;

        return $this;
    }
}
