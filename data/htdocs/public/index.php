<?php ini_set('display_errors', 1); require "../vendor/autoload.php";

$validator = new \Sva\EmailValidator();
$separator = ',';

$input = file_get_contents('php://input');
$emails = explode($separator, $input);

$result = [];
foreach ($emails as $key => $email) {
    $result[$email] = $validator->validate($email);
};
echo json_encode($result);
