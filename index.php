<?php

declare(strict_types=1);

use Alisakolosova\Hw3\TranslateProcessor;

require __DIR__ . '/vendor/autoload.php';

$num = new TranslateProcessor();

echo $num->getNumWord(2);