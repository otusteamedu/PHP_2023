<?php
declare(strict_types=1);

use Vasilaki\Php2023\App\App;

require 'vendor/autoload.php';

$app = new App();
$app->run();


const EMAIL_FILED_NAME = 'email';

$errors = [];
$email = $_POST[EMAIL_FILED_NAME] ?? null;
$isValidEmail = false;

if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    list($emailName, $hostName) = explode('@', $email);
    $mailList = [];
    getmxrr($hostName, $mailList);
    if (0 < count($mailList)) {
        $isValidEmail = true;
    } else {

        $errors[] = sprintf('Host %s is not available', $hostName);
    }
} else {
    $errors[] = sprintf('%s is not email address', $email);
}

if (0 == $isValidEmail) {
    http_response_code(200);
} else {
    http_response_code(400);
}
