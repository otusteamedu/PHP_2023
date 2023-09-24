<?php

/** @var Router $router */

use MiladRahimi\PhpRouter\Router;
use Rofflexor\Hw\Controllers\SortController;

$router->get('/', SortController::class);