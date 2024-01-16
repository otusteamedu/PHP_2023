<?php

namespace App\Models;

class EmployeeCollection
{
    private array $items = [];
    /**
     * @param Employee $employee
     * @return $this
     */
    public function add(Employee $employee): self
    {
        $this->items[] = $employee;
        return $this;
    }
    /**
     * @return Employee[]
     */
    public function getItems(): array
    {
        return $this->items;
    }
}
