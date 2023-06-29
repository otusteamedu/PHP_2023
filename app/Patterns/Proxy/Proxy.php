<?php
declare(strict_types=1);

namespace Proxy;

class Proxy implements Subject
{
    private $realSubject;

    public function __construct()
    {
        $this->realSubject = new RealSubject();
    }

    public function request()
    {
        echo "Proxy: Logging the request." . PHP_EOL;

        $this->realSubject->request();

        echo "Proxy: Post-processing the request." . PHP_EOL;
    }
}
