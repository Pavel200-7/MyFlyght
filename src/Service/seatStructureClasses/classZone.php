<?php

namespace App\Service\seatStructureClasses;

class classZone
{
    private array $sectors;

    public function __construct(){
        $this->addSector();
    }

    public function getSectors(): array
    {
        return $this->sectors;
    }

    public function setSectors(array $sectors): classZone
    {
        $this->sectors = $sectors;

        return $this;
    }

    public function addSector(): void
    {
        $this->sectors[] = new zoneSector();
    }

    public function addSectorCopy(zoneSector $zoneSector): void
    {
        $this->sectors[] = $zoneSector;
    }

    public function delSector(zoneSector $zoneSector): void
    {
        unset($this->sectors[array_search($zoneSector, $this->sectors)]);
    }

}