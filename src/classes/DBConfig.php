<?php

namespace Klobkovsky\Hw11;

class DBConfig
{
    public static function getNormalizedParams($params)
    {
        return [
            $params['host'],
            $params['user'],
            $params['password'],
            $params['database'],
            $params['port'],
        ];
    }
}
