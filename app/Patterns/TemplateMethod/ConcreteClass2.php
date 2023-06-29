<?php
declare(strict_types=1);

namespace TemplateMethod;

use TemplateMethod;

class ConcreteClass2 extends TemplateMethod\AbstractClass
{
    protected function requiredOperation1(): void
    {
        echo "ConcreteClass2 says: Implemented Operation1\n";
    }

    protected function requiredOperation2(): void
    {
        echo "ConcreteClass2 says: Implemented Operation2\n";
    }

    protected function hook1(): void
    {
        echo "ConcreteClass2 says: Overridden Hook1\n";
    }
}
