<?php

namespace App\Entity;

use App\Repository\AircraftRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: AircraftRepository::class)]
#[UniqueEntity(fields: ['registrationNumber'], message: 'Этот регистрационный номер занят')]
class Aircraft
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Airline::class)]
    #[ORM\JoinColumn(name: 'Airline_id', referencedColumnName: 'id', onDelete: "CASCADE")]
    private ?Airline $airlineId = null;

    #[ORM\ManyToOne(targetEntity: AircraftModel::class)]
    #[ORM\JoinColumn(name: 'AircraftModel_id', referencedColumnName: 'id')]
    private ?AircraftModel $aircraftModelId = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $manufactureDate = null;

    #[ORM\Column(length: 7)]
    private ?string $registrationNumber = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAirlineId(): ?Airline
    {
        return $this->airlineId;
    }

    public function setAirlineId(?Airline $airlineId): static
    {
        $this->airlineId = $airlineId;

        return $this;
    }

    public function getAircraftModelId(): ?AircraftModel
    {
        return $this->aircraftModelId;
    }

    public function setAircraftModelId(?AircraftModel $aircraftModelId): static
    {
        $this->aircraftModelId = $aircraftModelId;

        return $this;
    }

    public function getManufactureDate(): ?\DateTimeInterface
    {
        return $this->manufactureDate;
    }

    public function setManufactureDate(\DateTimeInterface $manufactureDate): static
    {
        $this->manufactureDate = $manufactureDate;

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
