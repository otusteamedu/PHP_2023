<?php
declare(strict_types=1);

namespace Ekovalev\Otus\Controllers;

use Ekovalev\Otus\Models\Check;

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