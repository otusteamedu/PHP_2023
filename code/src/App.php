<?php

declare(strict_types=1);

namespace Application;

use Application\Validator;

class App
{
    private Validator $validator;

    public function __construct()
    {
        $this->validator = new Validator();
    }

    public function run():void
    {
        // Сюда будет приходить строка. Раскоментировать для реальных проверок
        //$inputString = $_POST['string'] ?? '';

        // Для теста иммитрую на входе валидную строку. Для проверки невалидной, можно отредактировать строку на соответсвующую
        $inputString = '(()()()())';
        $this->validator->validate($inputString);
    }
}