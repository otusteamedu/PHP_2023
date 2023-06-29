<?php
declare(strict_types=1);

namespace Component;

class Composite implements ComponentInterface
{
    private $name;
    private $components;

    public function __construct($name)
    {
        $this->name = $name;
        $this->components = [];
    }

    public function add(ComponentInterface $component)
    {
        $this->components[] = $component;
    }

    public function remove(ComponentInterface $component)
    {
        $index = array_search($component, $this->components, true);
        if ($index !== false) {
            unset($this->components[$index]);
        }
    }

    public function operation()
    {
        echo "Composite " . $this->name . " is performing operation." . PHP_EOL;
        foreach ($this->components as $component) {
            $component->operation();
        }
    }
}
