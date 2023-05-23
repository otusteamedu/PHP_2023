<?php

namespace Yakovgulyuta\Hw13\Config;

use League\Config\Configuration;
use Yakovgulyuta\Hw13\Config\Database\Params;
use Yakovgulyuta\Hw13\Config\Database\Schema;

class InitConfig
{
    public static function init(): Configuration
    {
        $configuration = new Configuration(
            Schema::getConfigSchema(),
        );
        $configuration->merge(
            Params::getParams(),
        );

        return $configuration;
    }
}
