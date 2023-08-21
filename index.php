<?php

declare(strict_types=1);

use Adrapeza\ComposerHello\ComposerHello;

require __DIR__ . '/vendor/autoload.php';

$processor = new ComposerHello();
echo $processor->sayHello("Alex");