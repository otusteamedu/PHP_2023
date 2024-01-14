<?php

use Psr\Container\ContainerInterface;

if (!function_exists('env')) {
    function env($key, $default = null)
    {
        $value = getenv($key);
        if ($value === false) {
            return $default;
        }
        return $value;
    }
}

if (!function_exists('container')) {
    function container(): ContainerInterface
    {
        static $container;

        if (!$container) {
            $builder = new DI\ContainerBuilder();
            $definitions = require __DIR__ . '/../config/di.php';
            $container = $builder->addDefinitions($definitions);
            $container = $builder->build();
        }

        return $container;
    }
}

if (!function_exists('config')) {
    function config(): Common\Application\ConfigInterface
    {
        static $cfg;
        if (!$cfg) {
            $cfg = require __DIR__ . '/../config/config.php';
            $cfg = container()->make(Common\Application\ConfigInterface::class, [
                'config' => $cfg
            ]);
        }

        return $cfg;
    }
}
