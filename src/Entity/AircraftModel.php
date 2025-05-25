<?php

namespace App\Entity;

use App\Repository\AircraftModelRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: AircraftModelRepository::class)]
#[UniqueEntity(fields: ['model'], message: 'Это название модели уже занято')]
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
    private ?SeatsDiscriptionShablon $seatsDiscriptionId = null;

    #[ORM\ManyToOne(targetEntity: Manufacturers::class)]
    #[ORM\JoinColumn(name: 'Manufacturers_id', referencedColumnName: 'id')]
    private ?Manufacturers $manufacturerId = null;

    #[ORM\Column]
    private ?int $maxSits = null;

    #[ORM\Column]
    private ?int $maxWeight = null;

    #[ORM\Column]
    private ?int $averageSpeed = null;

    #[ORM\Column]
    private ?int $range = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(?string $model): static
    {
        $this->model = $model;

        return $this;
    }


    public function getSeatsDiscriptionId(): ?SeatsDiscriptionShablon
    {
        return $this->seatsDiscriptionId;
    }

    public function setSeatsDiscriptionId(?SeatsDiscriptionShablon $seatsDiscriptionId): static
    {
        $this->seatsDiscriptionId = $seatsDiscriptionId;

        return $this;
    }

    public function getMaxSits(): ?int
    {
        return $this->maxSits;
    }

    public function setMaxSits(int $maxSits): static
    {
        $this->maxSits = $maxSits;

        return $this;
    }

    public function getMaxWeight(): ?int
    {
        return $this->maxWeight;
    }

    public function setMaxWeight(int $maxWeight): static
    {
        $this->maxWeight = $maxWeight;

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

    public function getManufacturerId(): Manufacturers|null
    {
        return $this->manufacturerId;
    }

    public function setManufacturerId(Manufacturers|null $manufacturerId): static
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
