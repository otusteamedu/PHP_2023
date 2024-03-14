<?php

declare(strict_types=1);

namespace App;

use App\Rabbit\Client;
use App\Rabbit\Config;
use App\Rabbit\Publisher;
use Exception;

class App
{
    /**
     * @throws Exception
     */
    public function run(): void
    {
        $config = new Config();
        $client = new Client($config);
        $publisher = new Publisher($client);

        $msg = $_POST['msg'] ?? 'пустой запрос';

        $publisher->publish($msg);
    }
}
