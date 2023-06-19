<?php

namespace MyApp;

use MyApp\Validate;

class App
{

    public function run()
    {
        $validate = new Validate();

        // Получаем значение POST-параметра 'string'
        $string = $_POST['string'] ?? '';

        try {
            // Проверяем строку на валидность
            $validate->validateString($string);

            // Если все проверки прошли успешно, возвращаем ответ 200 OK
            $response = '200 OK: Все скобки в строке корректны.';
            $this->sendHttpResponse(200, $response);
        } catch (\Exception $e) {
            // Если возникла ошибка, возвращаем ответ 400 Bad Request
            $response = '400 Bad Request: Ошибка в строке скобок.';
            $this->sendHttpResponse(400, $response);
        }
    }

    private function sendHttpResponse($statusCode, $response)
    {
        // Устанавливаем HTTP-статус и заголовки ответа
        http_response_code($statusCode);
        header('Content-Type: text/plain');

        // Выводим тело ответа
        echo $response;
    }
}
