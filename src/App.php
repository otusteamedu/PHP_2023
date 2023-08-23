<?php

namespace Romank\Php2023;

class App
{
    public function run()
    {
        $validator = new Validator();
        $string = $_POST['string'] ?? '';

        try {
            $validator->validateString($string);
            $response = '200 OK';
            $this->sendHttpResponse(200, $response);
        } catch (\Exception $e) {
            $response = '400 Bad Request';
            $this->sendHttpResponse(400, $response);
        }
    }

    private function sendHttpResponse($statusCode, $response)
    {
        http_response_code($statusCode);
        header('Content-Type: text/plain');
        echo $response;
    }
}
