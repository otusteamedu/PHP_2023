<?php
require_once 'vendor/autoload.php';

$data = [1, 7.7, 2, 3.3, 7.7, 5.67, 2, 1.1, 7.7, 9];
$stat = new \Yalanskiy\SimpleStat\Stat($data);

echo $stat->count();
echo PHP_EOL;

echo $stat->summ();
echo PHP_EOL;

echo $stat->arithmeticMean();
echo PHP_EOL;

echo $stat->geometricMean();
echo PHP_EOL;

echo $stat->median();
echo PHP_EOL;

echo $stat->mode();
echo PHP_EOL;
