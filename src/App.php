<?php
declare(strict_types=1);

namespace Ekovalev\Otus;

use Ekovalev\Otus\Helpers\Utilities;


class App
{
    public function run()
    {
        return [
            Utilities::emailVerification('test@ya.ru'),
            Utilities::emailVerification('testya.ru'),
            Utilities::emailVerification('testya.ru11')
        ];
    }
}