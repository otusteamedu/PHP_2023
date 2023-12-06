<?php
declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

try {
    $app = new \Shabanov\Otusphp\App($argv);
    $app->run();
} catch(\Exception $e) {
    throw new \Exception($e->getMessage());
}
