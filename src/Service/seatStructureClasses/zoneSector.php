<?php

namespace App\Service\seatStructureClasses;

class zoneSector
{
    private int $rowCount;
    private int $seatsInRow;

    public function __construct(){
        $this->rowCount = 1;
        $this->seatsInRow = 1;
    }

    public function getRowCount(): int
    {
        return $this->rowCount;
    }

    public function setRowCount(int $rowCount): static
    {
        $this->rowCount = $rowCount;

        return $this;
    }

    public function getSeatsInRow(): int
    {
        return $this->seatsInRow;
    }

    public function setSeatsInRow(int $seatsInRow): static
    {
        $this->seatsInRow = $seatsInRow;

        return $this;
    }

    public function increaseSeatsInRow()
    {
        $this->seatsInRow++;
    }

    public function decreaseSeatsInRow()
    {
        $this->seatsInRow--;
    }

    public function increaseSeatsInSector()
    {
        $this->seatsInRow++;
    }

    public function decreaseSeatsInSector()
    {
        $this->seatsInRow--;
    }

}