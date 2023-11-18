<?php

declare(strict_types=1);

use ArtyrYamaliev\ComposerPackage\Generation;

require __DIR__ . '/vendor/autoload.php';

$generation = new Generation();
echo $generation->getNameByYear(1996);
