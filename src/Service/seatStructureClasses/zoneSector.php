<?php

namespace App\Service\seatStructureClasses;

class zoneSector
{
    private array $rows;

    public function __construct(){
        $this->addRow();
    }

    public function getRows(): array
    {
        return $this->rows;
    }

    public function setRows(array $rows): static
    {
        $this->rows = $rows;

        return $this;
    }

    public function addRow(): void
    {
        $this->rows[] = new sectorRow();
    }

    public function addRowCopy(sectorRow $row): void
    {
        $this->rows[] = $row;
    }

    public function delRow(sectorRow $row): void
    {
        unset($this->rows[array_search($row, $this->rows)]);
    }

}