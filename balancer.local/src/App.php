<?php

namespace VladimirPetrov\EmailValidator;

use VladimirPetrov\EmailValidator\helpers\ResponseHelper;
use VladimirPetrov\EmailValidator\validator\EmailValidator;

class App
{
    private EmailValidator $validator;

    public function __construct()
    {
        $this->validator = new EmailValidator();
    }

    /**
     * @return void
     */
    public function run()
    {
        if ($_SERVER["REQUEST_METHOD"] != "POST") {
            ResponseHelper::errorMethodResponse();
        } else {
            if (!empty($_POST["emails"]) && $this->validator->validate($_POST["emails"])) {
                ResponseHelper::successResponse();
            } else {
                ResponseHelper::errorResponse();
            }
        }
    }
}
