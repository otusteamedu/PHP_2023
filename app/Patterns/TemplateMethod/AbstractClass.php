<?php
declare(strict_types=1);

namespace TemplateMethod;

abstract class AbstractClass
{
    // The template method defines the skeleton of an algorithm.
    public function templateMethod(): void
    {
        $this->baseOperation1();
        $this->requiredOperation1();
        $this->baseOperation2();
        $this->hook1();
        $this->requiredOperation2();
        $this->baseOperation3();
        $this->hook2();
    }

    protected function baseOperation1(): void
    {
        echo "AbstractClass says: I am doing the bulk of the work\n";
    }

    protected function baseOperation2(): void
    {
        echo "AbstractClass says: But I let subclasses override some operations\n";
    }

    protected function baseOperation3(): void
    {
        echo "AbstractClass says: But I am doing the bulk of the work anyway\n";
    }

    protected abstract function requiredOperation1(): void;

    protected abstract function requiredOperation2(): void;

    protected function hook1(): void
    {
    }

    protected function hook2(): void
    {
    }
}
