<?php

declare(strict_types=1);

namespace Khalikovdn\Hw3;

class App
{
    /**
     * @return void
     * @throws \Exception
     */
    public function run(): void
    {
        if ($_SERVER['REQUEST_URI'] === '/validation') {
            (new Validation())->run();
        }else{
            (new Balancer())->run();
        }
    }
}
