<?php

require '../vendor/autoload.php';

use App\Validator;

$validator = new Validator();
echo $validator->checkString();