<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use Aporivaev\Hw05\Hw05;

session_start();

$class = new Hw05();

if ($class->isPost()) {
    $class->validate();
} else {
    $env = $class->getEnv();
    echo "NGINX instance - {$env['nginx']}\n<br>\nPHP instance - {$env['php']}\n<br>\n";
    echo "History:<br>\n<ul>\n";

    $history = $class->historyGet();
    if (count($history)) {
        foreach ($history as $item) {
            echo "<li>{$item}</li>\n";
        }
    }

    echo "</ul>";
}
