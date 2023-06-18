<?php

declare(strict_types=1);

use KLobkovsky\Hw3Package\StringProcessor;

require __DIR__ . '/vendor/autoload.php';

$processor = new StringProcessor();
echo $processor->getDigitCount('I am 123 years old'); // 3
