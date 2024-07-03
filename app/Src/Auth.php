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
        return [
            'session_id' => session_id(),
            'container' => $_SERVER['HOSTNAME'],
            'server_addr' => $_SERVER['SERVER_ADDR'],
        ];
    }
}
