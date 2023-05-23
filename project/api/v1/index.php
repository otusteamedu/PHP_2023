<?php

declare(strict_types=1);


use Vp\App\Application\App;

require "../../vendor/autoload.php";

$routes = require_once __DIR__ . "/config/routes.php";

$app = new App($routes, new Silex\Application());
$app->run();
