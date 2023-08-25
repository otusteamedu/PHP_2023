<?php

namespace IilyukDmitryi\App;

use Di\Container;
use DI\ContainerBuilder;
use Exception;

class Di
{
    /**
     * @throws Exception
     */
    public static function getContainer(): Container
    {
        static $container;

        if (is_null($container)) {
            $diConfig = require_once dirname(__DIR__) . '/di-config.php';

            $containerBuilder = new ContainerBuilder();
            $containerBuilder->addDefinitions($diConfig);
            $container = $containerBuilder->build();
        }
        return $container;
    }
}
