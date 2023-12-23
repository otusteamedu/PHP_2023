<?php

declare(strict_types=1);

use SergeyAntonov\OtusComposerPackage\Reverser;

require '../vendor/autoload.php';

$reverser = new Reverser();
echo $reverser->execute('Тестовая строка текста!!!');
