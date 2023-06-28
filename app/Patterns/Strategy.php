<?php
declare(strict_types=1);


interface Strategy
{
    public function doOperation($num1, $num2);
}

class AdditionStrategy implements Strategy
{
    public function doOperation($num1, $num2)
    {
        return $num1 + $num2;
    }
}

class SubtractionStrategy implements Strategy
{
    public function doOperation($num1, $num2)
    {
        return $num1 - $num2;
    }
}

class Context
{
    private $strategy;

    public function setStrategy(Strategy $strategy)
    {
        $this->strategy = $strategy;
    }

    public function executeStrategy($num1, $num2)
    {
        return $this->strategy->doOperation($num1, $num2);
    }
}

$context = new Context();

$additionStrategy = new AdditionStrategy();
$context->setStrategy($additionStrategy);

$result = $context->executeStrategy(5, 3);
echo "Result of addition: " . $result . PHP_EOL;

$subtractionStrategy = new SubtractionStrategy();
$context->setStrategy($subtractionStrategy);

$result = $context->executeStrategy(5, 3);
echo "Result of subtraction: " . $result . PHP_EOL;


