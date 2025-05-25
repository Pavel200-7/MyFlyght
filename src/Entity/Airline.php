<?php

namespace App\Entity;

use App\Repository\AirlineRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: AirlineRepository::class)]
#[UniqueEntity(fields: ['airlineName'], message: 'Авиакомпания с таким названием уже внесена в систему')]
class Airline
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
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
