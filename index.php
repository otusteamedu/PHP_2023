<?php 

declare(strict_types=1);
require __DIR__ . '/vendor/autoload.php';

use AlexandraMalihina\Librarytest\Finder;


$finder = new Finder();
echo $finder->whoIsAwesome();
echo "\n";