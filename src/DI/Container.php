<?php

declare(strict_types=1);

namespace Twent\Hw12\DI;

use Symfony\Component\DependencyInjection\ContainerBuilder;

final class Container
{
    private static ?ContainerBuilder $instance = null;

    public static function getInstance(): ?ContainerBuilder
    {
        if (! self::$instance) {
            self::$instance = new ContainerBuilder();
        }

        return self::$instance;
    }

    public function __clone(): void
    {
    }

    public function __wakeup(): void
    {
    }
}
