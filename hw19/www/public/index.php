<?php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Shabanov\Otusphp\App;

try {
    $app = new App();
    $app();
} catch(Exception $e) {
    throw new Exception($e->getMessage());
}
