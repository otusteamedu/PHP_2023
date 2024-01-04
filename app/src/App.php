<?php

namespace Lesson5;

class App
{

    /**
     * @return string
     */
    public function run()
    {
        $controller = new Controller();
        $controller->get = $_GET;
        $controller->post = $_POST;

        $res = $controller->actionMain();

        header('Content-Type: application/json');
        if(count($controller->errors) > 0) {
            echo $this->httpBadRequest(json_encode($controller->errors, JSON_UNESCAPED_UNICODE));
        }
        http_response_code(200);
        echo $res;
    }


    /**
     * @param $message
     * @return string
     */
    function httpBadRequest($message)
    {
        http_response_code(400);
        return "Bad Request: \n$message";
    }
}