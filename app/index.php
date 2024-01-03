<?php

require __DIR__ . '/vendor/autoload.php';

$str = \Dsx90\StringHelperPackage\StringHelper::trim("
Packagist - это репозиторий пакетов Composer по умолчанию. 
Он позволяет вам находить пакеты и позволяет Composer знать,
 откуда взять код.
", 50);

print_r("$str \n");
