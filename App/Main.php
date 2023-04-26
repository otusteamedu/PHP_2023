<?php

namespace App;

class Main
{
    public function start(): void
    {
        $db = DB::getInstance('db:3306', $_ENV['MYSQL_DATABASE'], $_ENV['MYSQL_USER'], $_ENV['MYSQL_PASSWORD']);
        echo Redis::test();
        echo Memcached::test();
    }
}
