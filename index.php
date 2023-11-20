<?php

declare(strict_types=1);

use \DanielPalm\StringGenerator\NumberGenerator;

require __DIR__ . '/vendor/autoload.php';

$numberGenerator = new NumberGenerator();
$result = $numberGenerator->sumNumbersRecursively(1);

echo $result;