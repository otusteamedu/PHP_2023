<?php
declare(strict_types=1);

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;

$config = ORMSetup::createAttributeMetadataConfiguration(
    paths: [__DIR__ . "/src"],
    isDevMode: true,
);

$connection = DriverManager::getConnection([
    'driver' => $_ENV['DATABASE_TYPE'],
    'host' => $_ENV['DATABASE_HOST'],
    'port' => $_ENV['DATABASE_PORT'],
    'dbname' => $_ENV['DATABASE_DB'],
    'user' => $_ENV['DATABASE_USER'],
    'password' => $_ENV['DATABASE_PASSWORD'],
], $config);

$entityManager = new EntityManager($connection, $config);
