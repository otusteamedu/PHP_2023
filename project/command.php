<?php

declare(strict_types=1);

use DI\DependencyException;
use DI\NotFoundException;
use Vp\App\Services\Container;

include "bootstrap.php";

try {
    $container = Container::getInstance();
    $command = $container->get('Vp\App\Services\Command');
    $command->run($_SERVER['argv']);
} catch (DependencyException|NotFoundException $e) {
    echo $e->getMessage();
}
