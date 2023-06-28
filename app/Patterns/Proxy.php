<?php
declare(strict_types=1);


interface Subject
{
    public function request();
}

class RealSubject implements Subject
{
    public function request()
    {
        echo "RealSubject: Handling request." . PHP_EOL;
    }
}

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

$proxy = new Proxy();
$proxy->request();



