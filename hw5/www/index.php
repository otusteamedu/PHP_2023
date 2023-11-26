<?php
declare(strict_types=1);

include("vendor/autoload.php");

use Shabanov\Otus\Helper;

$arEmails = ["saveliy@mail.ru", "tratata@yandex.china123321", "alexey@niderlandy.usa"];
if (!empty($arEmails)) {
    foreach($arEmails as $email) {
        echo 'Проверка валидности email: ' . Helper::checkEmail($email) . '<br>';
        echo 'Проверка валидности MX записи домена: ' . Helper::checkMxDomain($email) . '<br>';
    }
}
