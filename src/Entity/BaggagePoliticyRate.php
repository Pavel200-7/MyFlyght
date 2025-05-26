<?php

namespace App\Entity;

use App\Repository\BaggagePoliticyRateRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BaggagePoliticyRateRepository::class)]
class BaggagePoliticyRate
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Airline::class)]
    #[ORM\JoinColumn(name: 'Airline_id', referencedColumnName: 'id', onDelete: "CASCADE")]
    private Airline|null $airlineID = null;

    #[ORM\ManyToOne(targetEntity: BaggagePoliticy::class)]
    #[ORM\JoinColumn(name: 'BaggagePoliticy_id', referencedColumnName: 'id')]
    private BaggagePoliticy|null $baggagePoliticyID = null;

    #[ORM\Column]
    private ?float $costPerKM = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAirlaneID(): ?Airline
    {
        return $this->airlineID;
    }

    public function setAirlane(?Airline $airlineID): static
    {
        $this->airlineID = $airlineID;

        return $this;
    }

    public function getBaggagePoliticyID(): ?BaggagePoliticy
    {
        return $this->baggagePoliticyID;
    }

    public function setBaggagePoliticyID(?BaggagePoliticy $baggagePoliticyID): static
    {
        $this->baggagePoliticyID = $baggagePoliticyID;

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
