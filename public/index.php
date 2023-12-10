<?php

declare(strict_types=1);

use Ddushinov\OtusComposerHw4\Hello;

error_reporting(E_ALL | E_STRICT);
ini_set('display_errors', 1);

header('Content-Type: text/html; charset=utf-8');

require __DIR__ . '/../vendor/autoload.php';

$processorStr = new \Dimvilkester\OtusComposerPackageHw4\ProcessorString();
echo '<h1>String length "test": ' . $processorStr->strLen('test') . ' symbols</h1>';
