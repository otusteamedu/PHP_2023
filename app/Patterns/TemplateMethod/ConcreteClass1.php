<?php
declare(strict_types=1);

namespace TemplateMethod;

use TemplateMethod;

class ConcreteClass1 extends TemplateMethod\AbstractClass
{
    protected function requiredOperation1(): void
    {
        echo "ConcreteClass1 says: Implemented Operation1\n";
    }

    protected function requiredOperation2(): void
    {
        echo "ConcreteClass1 says: Implemented Operation2\n";
    }
}
