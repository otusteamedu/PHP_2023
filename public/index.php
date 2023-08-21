<?php

declare(strict_types=1);

use MaximBazlov\Hw3\TestCalculator;

require __DIR__.'/../src/TestCalculator.php';
require __DIR__.'/../vendor/autoload.php';

$test = new TestCalculator();

$test->test();