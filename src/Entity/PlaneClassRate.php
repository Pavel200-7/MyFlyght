<?php

namespace App\Entity;

use App\Enum\CompartmentTypeEnum;
use App\Repository\PlaneClassRateRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlaneClassRateRepository::class)]
class PlaneClassRate
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Airline::class)]
    #[ORM\JoinColumn(name: 'Airline_id', referencedColumnName: 'id')]
    private Airline|null $airlineID = null;

    #[ORM\Column]
    private ?string $classType = null;

    #[ORM\Column]
    private ?float $costPerKM = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAirlineID(): ?Airline
    {
        return $this->airlineID;
    }

    public function setAirlineID(Airline $airlineID): static
    {
        $this->airlineID = $airlineID;

        return $this;
    }

    public function getClassType(): ?string
    {
        return $this->classType;
    }

    public function setClassType(?CompartmentTypeEnum $classType): static
    {
        $this->classType = $classType->value;

        return $this;
    }

    public function getCostPerKM(): ?float
    {
        return $this->costPerKM;
    }

    public function setCostPerKM(float $costPerKM): static
    {
        $this->costPerKM = $costPerKM;

        return $this;
    }
}
