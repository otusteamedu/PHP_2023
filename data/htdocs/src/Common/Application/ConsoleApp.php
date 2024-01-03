<?php

namespace Common\Application;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\ORM\Tools\Console\EntityManagerProvider\SingleManagerProvider;
use Psr\Container\ContainerInterface;

final readonly class ConsoleApp extends AbstractApp
{
    public function __construct(
        ContainerInterface $container,
        ConfigInterface $config
    ) {
        parent::__construct($container, $config);
    }

    public function run(): void
    {
        $entityManager = $this->getContainer()->get(EntityManagerInterface::class);
        $commands = require $this->getRootDir() . '/config/commands.php';

        ConsoleRunner::run(
            new SingleManagerProvider($entityManager),
            $commands
        );
    }
}
