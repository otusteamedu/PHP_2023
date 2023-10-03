<?php
declare(strict_types=1);

namespace Eevstifeev\Hw12;

class Application
{
    public function run(): void
    {
       Routes::chooseRoute();
    }
}