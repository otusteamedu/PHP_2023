<?php

declare(strict_types=1);

namespace App\Src;

use Exception;

class Auth
{

    private $redis = null;

    public function __construct()
    {
        session_start();
        $this->redis =  new \Redis();
    }

    public function auth()
    {
        try {
            $this->redis->connect('redis', 6379);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function info()
    {

        echo "Редис работает<br/>";
        echo 'Session id: ' . session_id() . '<br>';
        echo "Запрос обработал контейнер: " . $_SERVER['HOSTNAME'] . '<br>';
        echo "Запрос обработал сервер nginx c IP: " . $_SERVER['SERVER_ADDR'] . '<br>';
    }
}
