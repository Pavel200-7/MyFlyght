<?php

namespace App\Entity;

use App\Repository\AirportsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AirportsRepository::class)]
class Airports
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $airportName = null;

    #[ORM\ManyToOne(targetEntity: Cities::class)]
    #[ORM\JoinColumn(name: 'City_id', referencedColumnName: 'id')]
    private Cities|null $city = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 6)]
    private ?float $longtitude = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 6)]
    private ?float $latitude = null;

    #[ORM\Column]
    private ?int $timezone = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAirportName(): ?string
    {
        return $this->airportName;
    }

    public function setAirportName(string $airportName): static
    {
        $this->airportName = $airportName;

        return $this;
    }

    public function getCity(): ?Cities
    {
        return $this->city;
    }

    public function setCity(?Cities $city): static
    {
        $this->city = $city;

        return $this;
    }


    public function getLongtitude(): ?float
    {
        return $this->longtitude;
    }

    public function setLongtitude(float $longtitude): static
    {
        $this->longtitude = $longtitude;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(float $latitude): static
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getTimezone(): ?int
    {
        return $this->timezone;
    }

    public function setTimezone(int $timezone): static
    {
        $this->timezone = $timezone;

        return $this;
    }
}
