<?php

declare(strict_types=1);

include('vendor/autoload.php');

use MaximTsikhonov\PhpNod\CalculationProcessor;

$calculation = new CalculationProcessor();
$res = $calculation->nod(36, 6);

echo "НОД для чисел 36 и 6 = {$res}";