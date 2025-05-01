<?php

namespace App\Entity;

use App\Enum\CompartmentTypeEnum;
use App\Repository\SeatShablonRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SeatShablonRepository::class)]
class SeatShablon
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: SeatsDiscriptionShablon::class)]
    #[ORM\JoinColumn(name: 'SeatsDiscriptionShablon_id', referencedColumnName: 'id')]
    private SeatsDiscriptionShablon|null $SeatShablon = null;

    #[ORM\Column]
    private ?int $compartmentNumber = null;

    #[ORM\Column]
    private ?string $compartmentType = null;

    #[ORM\Column]
    private ?int $zoneNumber = null;

    #[ORM\Column]
    private ?int $sectorNumber = null;

    #[ORM\Column]
    private ?int $row = null;

    #[ORM\Column]
    private ?int $numberInRow = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSeatShablon(): ?SeatsDiscriptionShablon
    {
        return $this->SeatShablon;
    }

    public function setSeatShablon(?SeatsDiscriptionShablon $SeatShablon): static
    {
        $this->SeatShablon = $SeatShablon;

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

    public function getCompartmentType(): ?string
    {
        return $this->compartmentType;
    }

    public function setCompartmentType(?CompartmentTypeEnum $compartmentType): static
    {
        $this->compartmentType = $compartmentType->value;

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
}
