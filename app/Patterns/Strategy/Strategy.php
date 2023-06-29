<?php
declare(strict_types=1);


namespace Strategy;
use Context;
use Strategy;

$context = new Context();

$additionStrategy = new AdditionStrategy();
$context->setStrategy($additionStrategy);

$result = $context->executeStrategy(5, 3);
echo "Result of addition: " . $result . PHP_EOL;

$subtractionStrategy = new Strategy\SubtractionStrategy();
$context->setStrategy($subtractionStrategy);

$result = $context->executeStrategy(5, 3);
echo "Result of subtraction: " . $result . PHP_EOL;
