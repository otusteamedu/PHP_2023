<?php

declare(strict_types=1);

namespace Ndybnov\Hw03;

require __DIR__ . '/../vendor/autoload.php';

use NdybnovHw03\CnfRead\FileConfig;
use NdybnovHw03\CnfRead\ReadConfig;
use NdybnovHw03\CnfRead\Storage;


$fileConfig = new FileConfig();
$pathToFileConfig = __DIR__ . DIRECTORY_SEPARATOR . '..';
$fileConfig->setFilePath($pathToFileConfig);
$fileNameConfig = '.env';
$fileConfig->setFileName($fileNameConfig);
$pathFull = $fileConfig->getFullPath();

$readerConfig = new ReadConfig($pathFull);
$readerConfig->read();
$arrayConfig = $readerConfig->toArray();

$storage = new Storage();
$storage->fromArray($arrayConfig);


echo $storage->get(ConfigKeysDTO::KEY);
echo PHP_EOL;

echo $storage->get(ConfigKeysDTO::BKEY) ? '+' : '-';
echo PHP_EOL;

echo $storage->get('NOT-EXIST', false) ? '+exist+' : '-not-exist-';
echo PHP_EOL;
