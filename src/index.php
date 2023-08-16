<?php
declare(strict_types=1);

use MikhailArkhipov\PhpGeneratorId\GeneratorId;

require '../vendor/autoload.php';

$idGenerator = new generatorId();

$uniqueId = $idGenerator->generate();
echo "result 1: (" . $uniqueId . ") ";

$uniqueId = $idGenerator->generate(16);
echo "result 2: (" . $uniqueId . ")";
