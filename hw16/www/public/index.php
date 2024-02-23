<?php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Shabanov\Otusphp\App;

try {
    (new App())->run();
} catch (\Exception $e) {
    throw new \Exception($e->getMessage());
}
