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
    private ?string $AirportName = null;

    #[ORM\ManyToOne(targetEntity: Cities::class)]
    #[ORM\JoinColumn(name: 'City_id', referencedColumnName: 'id')]
    private Cities|null $City = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 0)]
    private ?string $longtitude = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 0)]
    private ?string $latitude = null;

    #[ORM\Column]
    private ?int $timezone = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAirportName(): ?string
    {
        return $this->AirportName;
    }

    public function setAirportName(string $AirportName): static
    {
        $this->AirportName = $AirportName;

        return $this;
    }

    public function getCity(): ?Cities
    {
        return $this->City;
    }

    public function setCity(?Cities $City): static
    {
        $this->City = $City;

        return $this;
    }


    public function getLongtitude(): ?string
    {
        return $this->longtitude;
    }

    public function setLongtitude(string $longtitude): static
    {
        $this->longtitude = $longtitude;

        return $this;
    }

    public function getLatitude(): ?string
    {
        return $this->latitude;
    }

    public function setLatitude(string $latitude): static
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
