<?php
declare(strict_types=1);

namespace Dmatrenin\Hw6;

use Dmatrenin\Hw6\Validator;
use Exception;

class App
{
    public function run()
    {
        try {
            http_response_code(200);
            Validator::validateEmails([
                'levitanoff@gmail.com',
                'matrenin.d.e@emk.ru',
                'Matrenin.d.e@emk.ru',
                'Matrenin.d.e@em-k.ru', //Валидный E-mail. Домен не существует
            ]);
            echo 'Ok';
        }
        catch (Exception $exception) {
            http_response_code($exception->getCode());
            echo $exception->getMessage();
        }

    }
}