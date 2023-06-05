<?php

declare(strict_types=1);

require __DIR__ . '../../\vendor\autoload.php';

use Dpankratov\Hw4\Requests\StringValidation;

$str = readline("Введите скобочки: ");

if (isset($str)) {
    try {
        $res = new StringValidation($str);
        $res = $res->validation($str);
        echo 'Валидация пройдена :)';
    } catch (Exception $exception) {
        echo $exception->getMessage();
    }
} else {
    echo 'Введена пустая строка!';
}