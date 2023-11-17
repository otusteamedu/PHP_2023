<?php

declare(strict_types=1);

namespace Rvoznyi\ComposerTraining;
require '../vendor/autoload.php';

$processor = new ComposerHello();
echo $processor->sayHello("Otus");
