<?php
declare(strict_types=1);


interface Component
{
    public function operation();
}

class Leaf implements Component
{
    private $name;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function operation()
    {
        echo "Leaf " . $this->name . " is performing operation." . PHP_EOL;
    }
}

class Composite implements Component
{
    private $name;
    private $components;

    public function __construct($name)
    {
        $this->name = $name;
        $this->components = [];
    }

    public function add(Component $component)
    {
        $this->components[] = $component;
    }

    public function remove(Component $component)
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

$leaf1 = new Leaf("Leaf 1");
$leaf2 = new Leaf("Leaf 2");
$leaf3 = new Leaf("Leaf 3");

$composite1 = new Composite("Composite 1");
$composite1->add($leaf1);
$composite1->add($leaf2);

$composite2 = new Composite("Composite 2");
$composite2->add($leaf3);

$composite1->add($composite2);

$composite1->operation();
