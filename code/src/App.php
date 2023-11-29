<?php

namespace Radovinetch\Code;

use PDO;
use Throwable;

class App
{
    public function run(): void
    {
        //Проверка сессий
        echo 'Hostname: ' . $_SERVER['HOSTNAME'] . "<br/>";

        if (isset($_SESSION['test'])) {
            echo 'Session works fine!';
        } else {
            $_SESSION['test'] = 'test_key';
        }

        //Проверка MySQL
        try {
            $pdo = new PDO('mysql:host=mysql;dbname=test', 'test', 'test');
            $response = $pdo->query('SELECT 1');
            $response->execute();
            print_r($response->fetch());
        } catch (Throwable $throwable) {
            print_r($throwable);
            echo 'Соединение с БД НЕ установлено!';
        }

        $validator = new Validator();
        $validator->validate();
    }
}