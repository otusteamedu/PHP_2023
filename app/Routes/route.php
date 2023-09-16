<?php

/** @var Router $router */

use MiladRahimi\PhpRouter\Router;
use Rofflexor\Hw\Controllers\CheckEmailController;

$router->post('/', CheckEmailController::class);