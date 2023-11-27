<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use VladimirPetrov\OtusStringHelper\StringHelper;

$val = '123 456,78';
$floatVal = StringHelper::clearFloatVal($val);
echo $floatVal; // 123456.78
