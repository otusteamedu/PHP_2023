<?php

namespace Nautilus\Validator;

class App
{

    /**
     * @param array $request
     */
    public function __construct()
    {
    }

    public function run()
    {
        try {
            $emails = $_POST['emails'];
            $request = new Request($emails);
            $controller = new Controllers($request->getRequest());
            $validator = $controller->getValidatorEmail();
            echo $validator->getResult();
        } catch (\Exception $e) {
            echo $e->getMessage();
        }

    }

}