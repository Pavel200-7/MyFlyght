<?php

namespace App\Service\seatStructureClasses;

class planeClass
{
    private string $classType;
    private array $zones;

    public function __construct($classType)
    {
        $this->classType = $classType;
        $this->addZone();
    }

    public function getClassType(): string
    {
        return $this->classType;
    }

    public function setClassType(string $classType): planeClass
    {
        $this->classType = $classType;

        return $this;
    }

    public function getZones(): array
    {
        return $this->zones;
    }

    public function setZones(array $zones): planeClass
    {
        $this->zones = $zones;

        return $this;
    }

    public function addZone(): void
    {
        $this->zones[] = new classZone;
    }

    public function addZoneCopy(classZone $classZone): void
    {
        $this->zones[] = $classZone;
    }

    public function delZone(classZone $classZone): void
    {
        unset($this->zones[array_search($classZone, $this->zones)]);
    }

}