<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use function Wollkey\OtusPackage\sumOfThree;

echo sumOfThree(1)(2)(3);
