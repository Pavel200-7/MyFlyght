<?php

namespace App\Entity;

use App\Repository\AircraftModelRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AircraftModelRepository::class)]
class AircraftModel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $model = null;

    #[ORM\ManyToOne(targetEntity: SeatsDiscriptionShablon::class)]
    #[ORM\JoinColumn(name: 'SeatsDiscriptionShablon_id', referencedColumnName: 'id')]
    private SeatsDiscriptionShablon|null $seatsDiscriptionId = null;

    #[ORM\Column]
    private ?int $MaxSits = null;

    #[ORM\Column]
    private ?int $MaxWeight = null;

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(?string $model): static
    {
        $this->model = $model;

        return $this;
    }



    public function getSeatsDiscriptionId(): ?int
    {
        return $this->seatsDiscriptionId;
    }

    public function setSeatsDiscriptionId(int $seatsDiscriptionId): static
    {
        $this->seatsDiscriptionId = $seatsDiscriptionId;

        return $this;
    }

    public function getMaxSits(): ?int
    {
        return $this->MaxSits;
    }

    public function setMaxSits(int $MaxSits): static
    {
        $this->MaxSits = $MaxSits;

        return $this;
    }

    public function getMaxWeight(): ?int
    {
        return $this->MaxWeight;
    }

    public function setMaxWeight(int $MaxWeight): static
    {
        $this->MaxWeight = $MaxWeight;

        return $this;
    }

    public function getRange(): ?string
    {
        return $this->range;
    }

    public function setRange(string $range): static
    {
        $this->range = $range;

        return $this;
    }

    public function getManufacturerId(): ?int
    {
        return $this->manufacturerId;
    }

    public function setManufacturerId(int $manufacturerId): static
    {
        $this->manufacturerId = $manufacturerId;

        return $this;
    }

    public function getAverageSpeed(): ?int
    {
        return $this->averageSpeed;
    }

    public function setAverageSpeed(int $averageSpeed): static
    {
        $this->averageSpeed = $averageSpeed;

        return $this;
    }
}
