<?php
declare(strict_types=1);

function clientCode(TemplateMethod\AbstractClass $class)
{
    $class->templateMethod();
}

clientCode(new TemplateMethod\ConcreteClass1);
echo "\n";
clientCode(new TemplateMethod\ConcreteClass2);
