<?php

namespace App\Service\seatStructureClasses;

class planeClass
{
    private string $classType;
    private array $zones;

    public function __construct($classType)
    {
        $this->classType = $classType;
        $this->zones[] = new classZone;

    }

    public function getClassType(): string
    {
        return $this->classType;
    }

    public function setClassType(string $classType): static
    {
        $this->classType = $classType;

        return $this;
    }

    public function getZones(): array
    {
        return $this->zones;
    }

    public function setZones(array $zones): static
    {
        $this->zones = $zones;

        return $this;
    }

    public function addZone()
    {
        $this->zones[] = new classZone;
    }

    public function addZoneCopy(classZone $classZone)
    {
        $this->zones[] = $classZone;
    }

    public function delZone(classZone $classZone)
    {
        unset($this->zones[array_search($classZone, $this->zones)]);
    }

}