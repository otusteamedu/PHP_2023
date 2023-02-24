<?php

require "../../vendor/autoload.php";

$routes = require_once __DIR__ . "/config/routes.php";

$app = new \Vp\App\App($routes, new Silex\Application());
$app->run();
