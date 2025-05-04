<?php

namespace App\Entity;

use App\Repository\ManufacturersRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ManufacturersRepository::class)]
class Manufacturers
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $manufacturerName = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getManufacturerName(): ?string
    {
        return $this->manufacturerName;
    }

    public function setManufacturerName(?string $manufacturerName): static
    {
        $this->manufacturerName = $manufacturerName;

        return $this;
    }


}
