<?php

namespace Alexgaliy\ConsoleChat;

use Exception;

class Utils
{
    public static function getPathToSocket()
    {
        $key = "PATH_SOCKET_FILE";
        $config = require('config/config.ini.php');
        if (array_key_exists($key, $config)) {
            return $config[$key];
        }
        return null;
    }
}
