<?php

declare(strict_types=1);

namespace Ndybnov\Hw04\public;

require __DIR__ . '/../vendor/autoload.php';


use Ndybnov\Hw04\hw\AppWrapper;

try {
    AppWrapper::build()->run();
} catch (\Exception $e) {
    echo $e->getMessage();
}
