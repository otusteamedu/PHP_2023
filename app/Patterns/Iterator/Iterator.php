<?php
declare(strict_types=1);

use Iterator\NumberCollection;

$numberCollection = new NumberCollection();
$numberCollection->addItem(1);
$numberCollection->addItem(2);
$numberCollection->addItem(3);

foreach ($numberCollection->getIterator() as $number) {
    echo $number . "\n";
}
