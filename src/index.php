<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/vendor/autoload.php';

use Myklon\SimplePackage\Calculator;

$calc = new Calculator();

echo $calc->sum(1, 2);
