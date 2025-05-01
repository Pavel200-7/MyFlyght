<?php

namespace App\Entity;

use App\Enum\CompartmentTypeEnum;
use App\Repository\FlightsSeatsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FlightsSeatsRepository::class)]
class FlightsSeats
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Flights::class)]
    #[ORM\JoinColumn(name: 'Flights_id', referencedColumnName: 'id')]
    private Flights|null $flightId = null;

    #[ORM\Column]
    private ?int $compartmentNumber = null;

    #[ORM\Column]
    private CompartmentTypeEnum|null $compartmentType = null;

    #[ORM\Column]
    private ?int $zoneNumber = null;

    #[ORM\Column]
    private ?int $sectorNumber = null;

    #[ORM\Column]
    private ?int $row = null;

    #[ORM\Column]
    private ?int $numberInRow = null;

    #[ORM\Column]
    private ?bool $avalible = null;

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

    public function getCompartmentNumber(): ?int
    {
        return $this->compartmentNumber;
    }

    public function setCompartmentNumber(int $compartmentNumber): static
    {
        $this->compartmentNumber = $compartmentNumber;

        return $this;
    }

    public function getCompartmentType(): ?int
    {
        return $this->compartmentType;
    }

    public function setCompartmentType(int $compartmentType): static
    {
        $this->compartmentType = $compartmentType;

        return $this;
    }

    public function getZoneNumber(): ?int
    {
        return $this->zoneNumber;
    }

    public function setZoneNumber(int $zoneNumber): static
    {
        $this->zoneNumber = $zoneNumber;

        return $this;
    }

    public function getSectorNumber(): ?int
    {
        return $this->sectorNumber;
    }

    public function setSectorNumber(int $sectorNumber): static
    {
        $this->sectorNumber = $sectorNumber;

        return $this;
    }

    public function getRow(): ?int
    {
        return $this->row;
    }

    public function setRow(int $row): static
    {
        $this->row = $row;

        return $this;
    }

    public function getNumberInRow(): ?int
    {
        return $this->numberInRow;
    }

    public function setNumberInRow(int $numberInRow): static
    {
        $this->numberInRow = $numberInRow;

        return $this;
    }

    public function isAvalible(): ?bool
    {
        return $this->avalible;
    }

    public function setAvalible(bool $avalible): static
    {
        $this->avalible = $avalible;

        return $this;
    }
}
