<?php

declare(strict_types=1);

namespace DEsaulenko\Hw8;

class App
{
    public function run()
    {
        $solution = new Solution();
        $solution->runTests();
    }
}
