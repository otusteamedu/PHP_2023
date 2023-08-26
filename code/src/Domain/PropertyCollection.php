<?php

declare(strict_types=1);

namespace Art\Php2023\Domain;

class PropertyCollection
{
    private array $items = [];

    /**
     * @param Property $property
     * @return $this
     */
    public function add(Property $property): self
    {
        $this->items[] = $property;
        return $this;
    }

    /**
     * @return Property[]
     */
    public function getItems(): array
    {
        return $this->items;
    }
}
