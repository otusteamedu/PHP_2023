<?php

declare(strict_types=1);

use DI\DependencyException;
use DI\NotFoundException;
use Vp\App\Application\UseCase\Container;

include "bootstrap.php";

try {
    $container = Container::getInstance();
    $command = $container->get('Vp\App\Application\UseCase\Command');
    $command->run($_SERVER['argv']);
} catch (DependencyException|NotFoundException $e) {
    echo $e->getMessage();
}
