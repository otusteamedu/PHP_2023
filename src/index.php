<?php

require './vendor/autoload.php';
if (empty($_POST) || empty($_POST['string'])) {
    http_response_code(400);
    echo 'Empty string';
    exit;
}
use nikitaglobal\Validate as Validate;
new Validate($_POST['string']);
