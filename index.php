<?php
require __DIR__.'/vendor/autoload.php';

$mathService = new \Igalimov\OtusHwPackage\MathService();

echo $mathService->sum(2, 5);
echo PHP_EOL;
echo $mathService->pow(2, 10);
