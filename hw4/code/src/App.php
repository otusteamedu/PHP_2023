<?php

namespace Alexgaliy\AppValidator;

class App
{
    public function init()
    {
        $validator = new Validator();
        $string = $_POST['string'] ?? '';

        try {
            $validator->validateString($string);
            $response = '200 OK';
            $msg = 'Строка валидна.';
            $this->sendHttpResponse(200, $response, $msg);
        } catch (\Exception $e) {
            $response = '400 Bad Request';
            $msg = $e->getMessage();
            $this->sendHttpResponse(400, $response, $msg);
        }
    }

    private function sendHttpResponse($statusCode, $response, $msg)
    {
        http_response_code($statusCode);
        echo $response . ': ' . $msg;
    }
}
