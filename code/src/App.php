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
            } else {
                header("HTTP/1.1 400 Bad Request");
            }
        }
    }
}
