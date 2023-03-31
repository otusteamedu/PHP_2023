<?php

declare(strict_types=1);

use Vp\App\Config;

$config = Config::getInstance()
    ->setStorageType($_ENV['STORAGE_TYPE'])
    ->setDbUser($_ENV['DB_USER'])
    ->setDbPassword($_ENV['DB_PASSWORD'])
    ->setDbPort($_ENV['DB_PORT'])
    ->setDbName($_ENV['DB_NAME']);
