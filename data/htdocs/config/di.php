<?php

return [
    Common\Application\ConfigInterface::class => DI\autowire(Common\Application\Config::class),
    Common\Application\AppInterface::class => DI\autowire(Common\Application\WebApp::class),

    \PDO::class => function () {
        $dsn = sprintf(
            'pgsql:host=%s;port=%s;dbname=%s',
            config()->get('db.host'),
            config()->get('db.port'),
            config()->get('db.dbname')
        );

        return new \PDO($dsn, config()->get('db.user'), config()->get('db.password'));
    },

    \Geolocation\Domain\CityRepositoryInterface::class => DI\autowire(\Geolocation\Infrastructure\Mapper\CityMapper::class),
];
