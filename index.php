<?php

require __DIR__ . '/vendor/autoload.php';

use \YuzyukRoman\Reverse\StringTransformer;

echo StringTransformer::reverse('Hello World!') . "\n";
echo StringTransformer::doubleReverse('Hello World!');
