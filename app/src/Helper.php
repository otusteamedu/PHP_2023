<?php

namespace Root\Www;

use Exception;

class Helper
{
    const PATH_CONFIG_FILE = "/var/www/config/config.ini.php";

    public static function d($p)
    {
        print('<pre>');
        print_r($p);
        print('</pre>');
    }

    public static function conf($key)
    {
        $config_arr = require(Helper::PATH_CONFIG_FILE);
        if (array_key_exists($key, $config_arr)) {
            return $config_arr[$key];
        }
        return null;
    }

    public static function getConfig()
    {
        if (!file_exists(Helper::PATH_CONFIG_FILE)) {
            throw new Exception('Please include config file!');
        }
    }
}
