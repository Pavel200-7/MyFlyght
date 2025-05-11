<?php

namespace App\Entity;

use App\Repository\FlightsRepository;
use App\Service\IsPlaneCanBeInTime;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;


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
    #[ORM\JoinColumn(name: 'departure_airports_id', referencedColumnName: 'id')]
    private Airports|null $departureAirport = null;

//    #[Assert\NotIdenticalTo($this->departureAirport)]
    #[ORM\ManyToOne(targetEntity: Airports::class)]
    #[ORM\JoinColumn(name: 'arrival_airports_id', referencedColumnName: 'id')]
    private Airports|null $arrivalAirport = null;

    #[ORM\Column]
    private ?bool $finished = null;

    #[ORM\ManyToOne(targetEntity: Aircraft::class)]
    #[ORM\JoinColumn(name: 'Aircraft_id', referencedColumnName: 'id')]
    private Aircraft|null $aircraftId = null;


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

    public function getDepartureAirport(): ?Airports
    {
        return $this->departureAirport;
    }

    public function setDepartureAirport(Airports $departureAirport): static
    {
        $this->departureAirport = $departureAirport;

        return $this;
    }

    public function getArrivalAirport(): ?Airports
    {
        return $this->arrivalAirport;
    }

    public function setArrivalAirport(Airports $arrivalAirport): static
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

    public function getAircraftId(): ?Aircraft
    {
        return $this->aircraftId;
    }

    public function setAircraftId(Aircraft $aircraftId): static
    {
        $this->aircraftId = $aircraftId;

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

    public function getAirliniID(): ?Airline
    {
        return $this->airliniID;
    }

    public function setAirliniID(Airline $airliniID): static
    {
        $this->airliniID = $airliniID;

        return $this;
    }

    public function getHandLuggagePoliticyID(): ?HundLuggagePoliticy
    {
        return $this->handLuggagePoliticyID;
    }

    public function setHandLuggagePoliticyID(HundLuggagePoliticy $handLuggagePoliticyID): static
    {
        $this->handLuggagePoliticyID = $handLuggagePoliticyID;

        return $this;
    }

    public function getBaggagePoliticyID(): ?BaggagePoliticy
    {
        return $this->baggagePoliticyID;
    }

    public function setBaggagePoliticyID(BaggagePoliticy $baggagePoliticyID): static
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

    #[Assert\Callback]
    public function validate(ExecutionContextInterface $context, mixed $payload): void
    {
        if ($this->getDepartureAirport() ===  $this->getArrivalAirport()) {
            $context->buildViolation('Аэропорт отправки и прибытия должны быть разными')
                ->atPath('arrivalAirport')
                ->addViolation()
            ;
        }
    }


}


