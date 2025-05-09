<?php

namespace App\Service\seatStructureClasses;

class rowSeat
{
    private bool $available;

    public function __construct()
    {
        $this->available = true;
    }

    public function getSeatStatus(): bool
    {
        return $this->available;
    }

    public function setSeatStatus_available(): rowSeat
    {
        $this->available = true;

        return $this;
    }

    public function setSeatStatus_unavailable(): rowSeat
    {
        $this->available = false;

        return $this;
    }

}