<?php

namespace App\Service\seatStructureClasses;

class sectorRow
{
    private array $seats;

    public function __construct(){
        $this->addSeat();
    }

    public function getSeats(): array
    {
        return $this->seats;
    }

    public function setSeats(array $seats): static
    {
        $this->seats = $seats;

        return $this;
    }

    public function addSeat(): void
    {
        $this->seats[] = new rowSeat();
    }

    public function delSeat(rowSeat $seat): void
    {
        unset($this->seats[array_search($seat, $this->seats)]);
    }

}