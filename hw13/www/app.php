<?php
declare(strict_types=1);

use \Shabanov\Otusphp\App;

require __DIR__ . '/vendor/autoload.php';

try {
    (new App())->run();
} catch (Exception $e) {
    throw new Exception($e->getMessage());
}
