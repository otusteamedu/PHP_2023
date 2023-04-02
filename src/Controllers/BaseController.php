<?php

declare(strict_types=1);

namespace Twent\Hw12\Controllers;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Twent\Hw12\DI\Container;

abstract class BaseController
{
    private ?ContainerBuilder $container = null;

    protected function getContainer(): ?ContainerBuilder
    {
        return Container::getInstance();
    }
}
