<?php

namespace App\Service\seatStructureClasses;

class classZone
{
    private array $sectors;

    public function __construct(){
        $this->sectors[] = new zoneSector();
    }

    public function getSectors(): array
    {
        return $this->sectors;
    }

    public function setSectors(array $sectors): static
    {
        $this->sectors = $sectors;

        return $this;
    }

    public function addSector(){
        $this->sectors[] = new zoneSector();
    }

    public function addSectorCopy(zoneSector $zoneSector){
        $this->sectors[] = $zoneSector;
    }

    public function delSector(zoneSector $zoneSector)
    {
        unset($this->sectors[array_search($zoneSector, $this->sectors)]);
    }

}