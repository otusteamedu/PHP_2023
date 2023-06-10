<?php

require 'BracketsValidator.php';

$app = new BracketsValidator($_POST);

if ($app->validate()) {
    http_response_code(200);
    echo '';
} else {
    http_response_code(400);
    echo '';
}