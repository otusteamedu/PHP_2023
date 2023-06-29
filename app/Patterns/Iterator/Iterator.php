<?php
declare(strict_types=1);

use Iterator\NumberSquaredIterator;

$numbers = new ArrayObject([1, 2, 3, 4, 5]);
$iterator = new NumberSquaredIterator($numbers->getIterator());

foreach ($iterator as $number) {
    echo $number . "\n";
}
