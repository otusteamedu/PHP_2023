<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

try {
    $app = new GregoryKarman\ChatInUnixSocket\App();
    $app->run();
} catch (Exception $e) {
    echo $e->getMessage();
}
