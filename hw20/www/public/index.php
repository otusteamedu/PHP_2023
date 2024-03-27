<?php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/bootstrap.php';

use Shabanov\Otusphp\App;

try {
    global $entityManager;
    (new App($entityManager))->run();
} catch(Exception $e) {
    throw new Exception($e->getMessage());
}
