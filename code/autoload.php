<?php
declare(strict_types=1);


spl_autoload_register(function ($className) {
    $prefix = 'code\\';
    $baseDir = __DIR__ . '/src/';

    $len = strlen($prefix);
    if (strncmp($prefix, $className, $len) !== 0) {
        return; // Class does not use the prefix, move to the next registered autoloader
    }

    $relativeClass = substr($className, $len);

    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';
//var_dump($file);die;
    if (file_exists($file)) {
        require_once $file;
    }
});

