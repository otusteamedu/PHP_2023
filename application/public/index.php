<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use Gesparo\Calculator\Calculator;

$calc = new Calculator();

echo 'This is manipulations with created package' . '<br>' . '<br>';

echo 'Sum: ' . $calc->add(1, 2) . '<br>';
echo 'Subtract: ' . $calc->subtract(1, 2) . '<br>';
echo 'Multiply: ' . $calc->multiply(1, 2) . '<br>';
echo 'Divide: ' . $calc->divide(1, 2) . '<br>';