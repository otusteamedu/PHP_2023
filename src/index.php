<?php
declare(strict_types=1);

ini_set('display_errors', 1);
error_reporting(E_ALL);

define("ROOT", dirname(__FILE__));
var_dump(ROOT);
require_once (ROOT . '/components/Router.php');

$router = new Router();
$router->run();