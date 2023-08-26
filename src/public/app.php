<?php

declare(strict_types=1);

namespace Ndybnov\Hw05\public;

require dirname(__DIR__) . '/vendor/autoload.php';

use Ndybnov\Hw05\hw\AppChat;

try {
    AppChat::build()->run();
} catch (\Exception $e) {
    echo $e->getMessage();
}
