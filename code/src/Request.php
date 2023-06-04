<?php

namespace Ayagudin\BrackersValid;

use Exception;

class Request
{
    /**
     * @throws Exception
     */
    public static function getRequest() {
        if(!empty($_POST['brackets']) && $_POST['brackets'] !== '') {
            $result = (new Controllers($_POST['brackets']))->getValidatorForString();
            $result->validation();
            echo $result->getResult();
            http_response_code($result->getStatusCode());
        } else {
            echo Errors::EMPTY_STRING;
            http_response_code(400);
        }
     }
}