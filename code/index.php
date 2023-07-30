<?php

require_once './vendor/autoload.php';

use app\Validator;

if ($_POST) {
    $request = $_POST['string'];
    $validator = new \app\Validator();
    $response = $validator->validate($request);
    echo $validator->provideResponse();
} else {
    echo $view;
}
