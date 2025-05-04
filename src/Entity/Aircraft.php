<?php

namespace App\Entity;

use App\Repository\AircraftRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AircraftRepository::class)]
class Aircraft
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Airline::class)]
    #[ORM\JoinColumn(name: 'Airline_id', referencedColumnName: 'id')]
    private Airline|null $airlineId = null;

    #[ORM\ManyToOne(targetEntity: AircraftModel::class)]
    #[ORM\JoinColumn(name: 'AircraftModel_id', referencedColumnName: 'id')]
    private AircraftModel|null $aircraftModelId = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $ManufactureDate = null;

    #[ORM\Column(length: 7)]
    private ?string $registrationNumber = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAirlineId(): ?int
    {
        return $this->airlineId;
    }

    public function setAirlineId(int $airlineId): static
    {
        $this->airlineId = $airlineId;

        return $this;
    }

    public function getAircraftModelId(): ?int
    {
        return $this->aircraftModelId;
    }

    public function setAircraftModelId(int $aircraftModelId): static
    {
        $this->aircraftModelId = $aircraftModelId;

        return $this;
    }

    public function getManufactureDate(): ?\DateTimeInterface
    {
        return $this->ManufactureDate;
    }

    public function setManufactureDate(\DateTimeInterface $ManufactureDate): static
    {
        $this->ManufactureDate = $ManufactureDate;

        return $this;
    }

    public function getRegistrationNumber(): ?string
    {
        return $this->registrationNumber;
    }

    public function setRegistrationNumber(string $registrationNumber): static
    {
        $this->registrationNumber = $registrationNumber;

        return $this;
    }
}
