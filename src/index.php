<?php
declare(strict_types=1);

use Ekovalev\Otus\Components\Router;

ini_set('display_errors', 1);
error_reporting(E_ALL);

define("ROOT", dirname(__FILE__));

require_once(ROOT . '/vendor/autoload.php');

$router = new Router();
$router->run();