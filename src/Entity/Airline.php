<?php

namespace App\Entity;

use App\Repository\AirlineRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AirlineRepository::class)]
class Airline
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $airlineName = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAirlineName(): ?string
    {
        return $this->airlineName;
    }

    public function setAirlineName(string $airlineName): static
    {
        $this->airlineName = $airlineName;

        return $this;
    }
}
