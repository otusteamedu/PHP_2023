<?php
declare(strict_types=1);


spl_autoload_register(function ($class) {
    // convert namespace to file path
    var_dump($class);die;
    $path = str_replace('\\', '/', $class) . '.php';
//var_dump($path);die();
    // check if the file exists
    if (file_exists($path)) {
        require_once $path;
    }
});
