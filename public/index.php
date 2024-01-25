<?php

use App\Helpers\Functions;

require_once __DIR__ . '/../vendor/autoload.php';

$func = new Functions();

echo $func->fractionToDecimal(1, 5);
