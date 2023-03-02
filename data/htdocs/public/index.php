<?php
ini_set('display_errors', 1);
require "../vendor/autoload.php";

$validator = new \Sva\EmailValidator();

$result = [];
foreach((new \Sva\FileReader)->getLines('../emails.txt') as $key => $email) {
    $result[$email] = $validator->validate($email);
};
echo json_encode($result);
