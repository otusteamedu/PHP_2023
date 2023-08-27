<?php

declare(strict_types=1);

namespace Ndybnov\Hw06\public;

require dirname(__DIR__) . '/vendor/autoload.php';

use Ndybnov\Hw06\hw\AppEmails;

try {
    (new AppEmails())->run();
} catch (\Exception $e) {
    echo $e->getMessage();
}
