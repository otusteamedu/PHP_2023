<?php

namespace Code\App;

use Code\BracketsChecker\BracketsChecker;
use Code\Router\Router;

class App
{
    private $router;
    private $memcached;

    public function __construct()
    {
        $this->router = new Router($_SERVER['REQUEST_METHOD'], $_POST);
        $this->memcached = new \Memcached();
        $this->memcached->addServer('memcached1', 11211);
        $this->memcached->addServer('memcached2', 11212);
    }

    public function run()
    {
        $string = $this->router->route();
        if ($string !== null) {
            $isBalanced = BracketsChecker::isBracketsBalanced($string);
            $this->memcached->set('last_check_result', $isBalanced ? 'balanced' : 'not balanced');

            if ($isBalanced) {
                http_response_code(200);
                echo 'OK: The string is correct.';
            } else {
                http_response_code(400);
                echo 'Bad Request: The string is incorrect.';
            }
        }
    }
}