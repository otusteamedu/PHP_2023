<?php

declare(strict_types=1);

use Vp\App\App;
use Vp\App\Config;
use Vp\App\Services\CommandProcessor;

require_once('vendor/autoload.php');

try {

    Config::setConfig(parse_ini_file("config.ini", false, INI_SCANNER_TYPED));

    $app = new App(new CommandProcessor());
    $app->run($_SERVER['argv']);
}
catch(Exception $e) {
    fwrite(STDOUT, "Error: " . $e->getMessage() . PHP_EOL);
}
