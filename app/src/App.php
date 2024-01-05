<?php

namespace Lesson5;

class App
{

    /**
     * @return string
     */
    public function run(): string
    {
        $controller = new Controller();
        $controller->get = $_GET;
        $controller->post = $_POST;

        $arrPath = explode('/', $_SERVER['REQUEST_URI']);

        $pathAndParams = explode('?', $arrPath[count($arrPath) - 1]);
        $uri = $pathAndParams[0];

        if($uri == 'verifyEmail'){
            $res = $controller->actionVerifiyEmail();
        } else {
            $res = $controller->actionMain();
        }

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
    function httpBadRequest($message): string
    {
        http_response_code(400);
        return "Bad Request: \n$message";
    }
}