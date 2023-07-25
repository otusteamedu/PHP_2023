<?php

declare(strict_types=1);

use Otus\App\App;
use Otus\App\Database\IdentityMap;
use Otus\App\Database\UserMapper;

require_once __DIR__ . '/../vendor/autoload.php';

$pdo = new \PDO(
    dsn: 'pgsql:host=localhost;dbname=cinema',
    username: 'otus',
    password: 'secret'
);

$userMapper = new UserMapper($pdo, new IdentityMap());

(new App($userMapper))->run();
