<?php

namespace src\application\configure;

use DI\Container;
use src\config\ContainerInjectionsConfig;

class ContainerInjections
{
    private Container $container;

    private function __construct()
    {
        $this->setContainer(new Container());
    }

    public static function build(): self
    {
        return new self();
    }

    public function sets(): self
    {
        $container = $this->getContainer();

        foreach ($this->describes() as $keyDescribe => $describe) {
            $container->set($keyDescribe, $describe);
        }

        $this->setContainer($container);

        return $this;
    }

    private function describes(): array
    {
        return ContainerInjectionsConfig::describes();
    }

    public function getContainer(): Container
    {
        return $this->container;
    }

    private function setContainer(Container $container): void
    {
        $this->container = $container;
    }
}
