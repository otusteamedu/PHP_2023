<?php

namespace Common\Application;

use Psr\Container\ContainerInterface;

abstract readonly class AbstractApp implements AppInterface
{
    private string $rootDir;

    public function __construct(
        private readonly ContainerInterface $container,
        private readonly ConfigInterface $config
    ) {
        $this->rootDir = dirname(dirname(dirname(__DIR__)));
    }

    /**
     * @return ContainerInterface
     */
    public function getContainer(): ContainerInterface
    {
        return $this->container;
    }

    /**
     * @return Config
     */
    public function getConfig(): Config
    {
        return $this->config;
    }

    /**
     * @return string
     */
    public function getRootDir(): string
    {
        return $this->rootDir;
    }
}
