<?php

declare(strict_types=1);

use Dotenv\Dotenv;
use User\Php2023\DependencyInjectionBootstrap;
use User\Php2023\DIContainer;

$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();
$container = new DIContainer();
DependencyInjectionBootstrap::setUp($container);
