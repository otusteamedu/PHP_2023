<?php

namespace MyApp;

use MyApp\Validate;

class App {
    public function run() {
        $validate = new Validate();

        // Получаем значение POST-параметра 'string'
        $string = $_POST['string'] ?? '';

        try {
            // Проверяем строку на валидность
            $validate->validateString($string);

            // Если все проверки прошли успешно, возвращаем ответ 200 OK
            return "200 OK: Все скобки в строке корректны.";
        } catch (\Exception $e) {
            // Если возникла ошибка, возвращаем ответ 400 Bad Request
            return "400 Bad Request: Ошибка в строке скобок.";
        }
    }
}
