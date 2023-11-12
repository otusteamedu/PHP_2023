<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use Propan\NumberExtractor\NumberExtractor;

$numbers = NumberExtractor::extract('16 бутылок молока и -7 бытолок кефира');
print_r($numbers);
