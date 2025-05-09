<?php

namespace App\Service\seatStructureClasses;

class seatStructure
{
    private array $classes;

    public function getClasses(): array
    {
        return $this->classes;
    }

    public function setClasses(array $classes): static
    {
        $this->classes = $classes;

        return $this;
    }

    public function addClass($classType): void
    {
        $this->classes[] = new planeClass($classType);
    }

    public function addClassCopy(planeClass $planeClass): void
    {
        $this->classes[] = $planeClass;
    }

    public function delClass(planeClass $planeClass): void
    {
        unset($this->classes[array_search($planeClass, $this->classes)]);
    }

}





