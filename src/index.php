<?php

declare(strict_types=1);

use ArtemCherepanov\OtusComposerPackage\StringProcessor;

require __DIR__ . '/../vendor/autoload.php';

$processor = new StringProcessor();
echo $processor->getLength('foo bar');
