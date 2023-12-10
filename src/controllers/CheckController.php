<?php
declare(strict_types=1);

include_once ROOT . '/models/Check.php';

class CheckController
{
    public function actionService()
    {

        $variable = [
            Check::mysqlCheck(),
            Check::redisCheck(),
            Check::memcacheCheck()
        ];


        extract(compact('variable'));
        //return view("home.php",compact('variable'));
        include ROOT . '/views/check.php';
    }
}