<?php

namespace Cases\Php2023\Domain\Pattern\Composite;

use Cases\Php2023\Domain\Aggregates\Interface\DishComponentInterface;

class OrderComposite {
    private array $children;

    public function __construct() {
        $this->children = [];
    }

    public function addComponent(DishComponentInterface $component): void
    {
        $this->children[] = $component;
    }

    public function removeComponent(DishComponentInterface $component): void
    {
        if(($key = array_search($component, $this->children, true)) !== false) {
            unset($this->children[$key]);
        }
    }

    public function getNames(): string
    {
        $fullOrderName = '';
        foreach ($this->children as $child) {
            $fullOrderName .= $child->getName() . ' ';
        }
        return $fullOrderName;
    }
}
