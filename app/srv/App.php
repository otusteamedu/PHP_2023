<?php

declare(strict_types=1);

namespace App\Hw4;

class App
{
    public function run(): void
    {
        $string = '(((((())))))';

        print(Result::result((new Validator())->validateString($string)));
    }
}
