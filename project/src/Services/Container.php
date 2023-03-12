<?php

declare(strict_types=1);

namespace Vp\App\Services;

class Container
{
    private \DI\Container $container;

    public function __construct()
    {
        $this->container = new \DI\Container();
    }

    public static function getInstance(): \DI\Container
    {
        static $self = null;

        if (!$self) {
            $self = new self();
        }

        return $self->container;
    }
}
