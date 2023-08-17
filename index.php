<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use IvanSochkov\OtusComposerPackage\Services\ExponentiationService;

$exp = new ExponentiationService();
echo $exp->Exponentiation(4, 2); // 16