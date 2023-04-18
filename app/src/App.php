<?php

namespace Yakovgulyuta\Hw5;

class App
{
    public function run(): void
    {
        $controller = new Controller();
        $controller->validateEmails();
    }

}