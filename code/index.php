<?php
require __DIR__ . '/validator/EmailValidator.php';

if (isset($_REQUEST['email'])) {
    $validator = new \app\validator\EmailValidator($_REQUEST['email']);
    if ($validator->checkIsCorrect()) {
        echo 'Проверка прошла успешно';
    } else {
        echo 'Email некорректен';
    }
}
