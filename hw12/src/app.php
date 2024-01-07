<?php
declare(strict_types=1);

namespace Elena\Hw12;

use Exception;
use Predis\Client;

class App
{
    function run()
    {
        $client = new RedisConnect();

        $uri = trim($_SERVER['REQUEST_URI'],'/');

        if ($uri === ''){
            $result = 'Clear, select or add';
        }elseif ($uri === 'clear'){
            $result = $client->clear();
        }elseif (preg_match("/^(select)/",$uri)>0) {
            $criteria = $_GET;
            $result = $client->select_event($criteria);
        }elseif ($uri === 'add') {
            $result = $client->add();
        }else{
            $result = '404';
        }
        echo $result;

    }


}
