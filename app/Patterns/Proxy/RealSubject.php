<?php
declare(strict_types=1);

namespace Proxy;

use Proxy\Proxy;

class RealSubject implements Subject
{
    public function request()
    {
        echo "RealSubject: Handling request." . PHP_EOL;
    }
}