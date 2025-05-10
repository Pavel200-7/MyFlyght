<?php

namespace App\Entity;

use App\Repository\BaggagePoliticyRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BaggagePoliticyRepository::class)]
class BaggagePoliticy
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?string $baggagePoliticyname = null;

    #[ORM\Column]
    private ?int $itemsCount = null;

    #[ORM\Column]
    private ?int $weightPerItem = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBaggagePoliticyname(): ?string
    {
        return $this->baggagePoliticyname;
    }

    public function setBaggagePoliticyname(?string $baggagePoliticyname): static
    {
        $this->baggagePoliticyname = $baggagePoliticyname;

        return $this;
    }



    public function getItemsCount(): ?int
    {
        return $this->itemsCount;
    }

    public function setItemsCount(int $itemsCount): static
    {
        $this->itemsCount = $itemsCount;

        return $this;
    }

    public function getWeightPerItem(): ?int
    {
        return $this->weightPerItem;
    }

    public function setWeightPerItem(int $weightPerItem): static
    {
        $this->weightPerItem = $weightPerItem;

        return $this;
    }
}
