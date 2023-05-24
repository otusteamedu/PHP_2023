<?php

require './vendor/autoload.php';
use nikitaglobal\Validate as Validate;
$validator = new Validate();
$validator->checkEmail()->checkEmailMx()->generateResponse() ? http_response_code(200) : http_response_code(400);
