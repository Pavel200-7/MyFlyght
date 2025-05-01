<?php

namespace App\Entity;

use App\Repository\SeatsDiscriptionShablonRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SeatsDiscriptionShablonRepository::class)]
class SeatsDiscriptionShablon
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $SeatsDiscriptionShablonName = null;

    #[ORM\ManyToOne(targetEntity: SeatsDiscriptionShablon::class)]
    #[ORM\JoinColumn(name: 'SeatsShablon_id', referencedColumnName: 'id')]
    private SeatsDiscriptionShablon|null $SeatsShablonId = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSeatsDiscriptionShablonName(): ?string
    {
        return $this->SeatsDiscriptionShablonName;
    }

    public function setSeatsDiscriptionShablonName(string $SeatsDiscriptionShablonName): static
    {
        $this->SeatsDiscriptionShablonName = $SeatsDiscriptionShablonName;

        return $this;
    }

    public function getSeatsShablonId(): ?int
    {
        return $this->SeatsShablonId;
    }

    public function setSeatsShablonId(int $SeatsShablonId): static
    {
        $this->SeatsShablonId = $SeatsShablonId;

        return $this;
    }
}
