<?php
    return [
        'database' => [
            'host' => getenv('MYSQL_HOST'),
            'name' => getenv('MYSQL_DATABASE'),
            'user' => getenv('MYSQL_USER'),
            'port' => getenv('MYSQL_PORT'),
            'password' => getenv('MYSQL_PASSWORD'),
        ],
        'redis' => [
            'host' => getenv('REDIS_HOST'),
            'port' => getenv('REDIS_PORT'),
            'password' => getenv('REDIS_PASSWORD'),
        ],
    ];