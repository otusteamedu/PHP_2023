<?php

declare(strict_types=1);

use supervoron\FormatterComposerPackage\StringFormatter;

require '../vendor/autoload.php';

$stringFormatter = new StringFormatter();
echo ($stringFormatter->toUpperCase('get it up'));