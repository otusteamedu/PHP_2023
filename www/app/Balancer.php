<?php

namespace Chernomordov\App;

class Balancer
{

    public function run(): void
    {
        echo 'ok ' . $_SERVER['HOSTNAME'];
    }
}