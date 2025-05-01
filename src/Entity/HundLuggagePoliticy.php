<?php

namespace App\Entity;

use App\Repository\HundLuggagePoliticyRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HundLuggagePoliticyRepository::class)]
class HundLuggagePoliticy
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[ORM\Column]
    private ?int $ItemsCount = null;

    #[ORM\Column]
    private ?int $weightPerItem = null;

    #[ORM\Column]
    private ?int $widthX = null;

    #[ORM\Column]
    private ?int $lengthY = null;

    #[ORM\Column]
    private ?int $heightZ = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHundLuggagePoliticyID(): ?int
    {
        return $this->HundLuggagePoliticyID;
    }

    public function setHundLuggagePoliticyID(int $HundLuggagePoliticyID): static
    {
        $this->HundLuggagePoliticyID = $HundLuggagePoliticyID;

        return $this;
    }

    public function getItemsCount(): ?int
    {
        return $this->ItemsCount;
    }

    public function setItemsCount(int $ItemsCount): static
    {
        $this->ItemsCount = $ItemsCount;

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

    public function getWidthX(): ?int
    {
        return $this->widthX;
    }

    public function setWidthX(int $widthX): static
    {
        $this->widthX = $widthX;

        return $this;
    }

    public function getLengthY(): ?int
    {
        return $this->lengthY;
    }

    public function setLengthY(int $lengthY): static
    {
        $this->lengthY = $lengthY;

        return $this;
    }

    public function getHeightZ(): ?int
    {
        return $this->heightZ;
    }

    public function setHeightZ(int $heightZ): static
    {
        $this->heightZ = $heightZ;

        return $this;
    }
}
