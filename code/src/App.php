<?php

namespace Application;

class App
{
    private Validator $validator;

    public function __construct()
    {
        $this->validator = new Validator();
    }

    /**
     * @return void
     */
    public function run()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (!empty($_POST["string"]) && $this->validator->controlBrackets($_POST["string"])) {
                header("HTTP/1.1 200 OK");
                echo "Всё хорошо ƪ(˘⌣˘)ʃ";
            } else {
                header("HTTP/1.1 400 Bad Request");
                echo "Всё плохо ¯\_(ツ)_/¯";
            }
        }
    }
}