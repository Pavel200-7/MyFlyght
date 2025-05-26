<?php

namespace App\Entity;

use App\Repository\SeatsDiscriptionShablonRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: SeatsDiscriptionShablonRepository::class)]
#[UniqueEntity(fields: ['seatsDiscriptionShablonName'], message: 'Это название шаблона занято')]
class SeatsDiscriptionShablon
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $seatsDiscriptionShablonName = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSeatsDiscriptionShablonName(): ?string
    {
        return $this->seatsDiscriptionShablonName;
    }

    public function setSeatsDiscriptionShablonName(string $seatsDiscriptionShablonName): static
    {
        $this->seatsDiscriptionShablonName = $seatsDiscriptionShablonName;

        return $this;
    }

}
