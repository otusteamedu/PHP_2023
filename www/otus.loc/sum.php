<?php

use Sherweb\OtusPackage\Calculator;

require_once __DIR__ . '/vendor/autoload.php';

echo (new Calculator)->exec(10, 13, '+');