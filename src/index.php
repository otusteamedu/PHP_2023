<?php

declare(strict_types=1);

use AleksandrDolgov\OtusStudentPackage\Reverser as Reverser;

require dirname(__DIR__) . '/vendor/autoload.php';

$reverser = new Reverser();
echo $reverser->reverseInt(123456) . "\n";
echo $reverser->reverseString('Hello Otus!');
