<?php
declare(strict_types=1);

function autoloadClasses($className) {

    $directories = [
        __DIR__,
        __DIR__ . '/Validator/',
        __DIR__ . '/Exceptions/',
    ];

    foreach ($directories as $directory) {
        $fileName = $directory . '/' . str_replace('\\', '/', $className) . '.php';
        if (file_exists($fileName)) {
            require $fileName;
            return true;
        }
    }

    return false;
}

spl_autoload_register('autoloadClasses');