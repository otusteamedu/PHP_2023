<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Amedvedev\FirstPackage\MyWords;

$myWords = new MyWords();

echo $myWords->getMyWords()[0];
