<?php
declare(strict_types=1);
require __DIR__ . '/vendor/autoload.php';
use Espiktarenko\Mortgage\MortgageCount;

$mr = new MortgageCount;

$summa = 20000;
$years = 15;
$procent = 2;

$a = $mr->mortage($summa, $years, $procent);

echo $a;




