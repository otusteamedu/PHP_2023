<?php

declare(strict_types=1);

use DEsaulenko\Hw8\App;

require_once 'vendor/autoload.php';

try {
    (new App())->run();
} catch (\Exception $e) {
    echo $e->getMessage();
}
