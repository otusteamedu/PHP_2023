<?php
declare(strict_types=1);

namespace Component;

class Leaf implements ComponentInterface
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
