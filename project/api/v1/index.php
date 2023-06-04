<?php

declare(strict_types=1);

error_reporting(E_ERROR);

use Vp\App\Application\App;
use Vp\App\Infrastructure\Exception\ApiConfigNotFound;

require_once "../../bootstrap.php";
$routes = require_once "../../config/routes.php";
$config = require_once "../../config/api.php";

try {
    $app = new App($routes, $config, new Silex\Application(), $_ENV);
    $app->run();
} catch (ApiConfigNotFound $e) {
    echo $e->getMessage();
}
