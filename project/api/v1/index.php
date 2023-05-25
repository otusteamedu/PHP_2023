<?php

declare(strict_types=1);

use Vp\App\Application\App;

require "../../vendor/autoload.php";
require_once "../../constant.php";
require_once "../../bootstrap.php";

$routes = require_once __DIR__ . "/config/routes.php";

$app = new App($routes, new Silex\Application(), $_ENV);
$app->run();
